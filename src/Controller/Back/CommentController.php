<?php

namespace App\Controller\Back;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\CommentRepository;

class CommentController extends AbstractController
{
  #[IsGranted('ROLE_CAN_MODERATE_COMMENT')]
  #[Route('/comment-validation', name: 'app_comment_validation')]
  public function index(CommentRepository $commentRepository): Response
  {
    $unvalidatedComment = $commentRepository->findBy(['validated_at' => null]);
    
    return $this->render('Back/comment/validation.html.twig', [
      'unvalidatedComment' => $unvalidatedComment,
    ]);
  }

  #[IsGranted('ROLE_CAN_MODERATE_COMMENT')]
  #[Route('/{id}/validate', name: 'app_comment_validate', methods: ['GET'])]
  public function validate(Comment $comment, CommentRepository $commentRepository): Response
  {
    $comment->setValidatedAt(new \DateTimeImmutable());
    $commentRepository->save($comment, true);
    return $this->redirectToRoute('admin_app_comment_validation', [], Response::HTTP_SEE_OTHER);
  }

  #[IsGranted('ROLE_CAN_MODERATE_COMMENT')]
  #[Route('/{id}/del-validation', name: 'app_comment_delete_validation', methods: ['POST'])]
  public function deleteValidation(Request $request, Comment $comment, CommentRepository $commentRepository): Response
  {
      if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
          $commentRepository->remove($comment, true);
      }

      return $this->redirectToRoute('admin_app_comment_validation', [], Response::HTTP_SEE_OTHER);
  }
}
