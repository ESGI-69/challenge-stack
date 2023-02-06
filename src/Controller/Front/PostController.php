<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class PostController extends AbstractController
{
  #[Route('/{slug}', name: 'app_post_show', methods: ['GET', 'POST'])]
  public function show(Post $post, CommentRepository $commentRepository, Request $request): Response
  {
    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $comment->setIdUser($this->getUser());
      $comment->setIdPost($post);
      $comment->setCreatedAt(new \DateTimeImmutable());
      $comment->setValidatedAt(null);
      
      $commentRepository->save($comment, true);

      return $this->redirectToRoute('front_app_post_show', ["slug" => $post->getSlug()], Response::HTTP_SEE_OTHER);
    }

    return $this->render('Front/post/show.html.twig', [
      'post' => $post,
        'form' => $form->createView(),
    ]);
  }
  
}
