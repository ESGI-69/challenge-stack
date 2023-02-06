<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\CommentRepository;

class CommentController extends AbstractController
{
  #[IsGranted('ROLE_CAN_MODERATE_COMMENT')]
  #[Route('/comment-validation', name: 'comment_validation')]
  public function index(CommentRepository $commentRepository): Response
  {
    $unvalidatedComment = $commentRepository->findBy(['validated_at' => null]);
    
    return $this->render('Back/comment/validation.html.twig', [
      'unvalidatedComment' => $unvalidatedComment,
    ]);
  }
}
