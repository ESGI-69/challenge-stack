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
use App\Form\SearchType;


#[Route('/post')]
class PostController extends AbstractController
{
  #[Route('/{slug}', name: 'app_post_show', methods: ['GET', 'POST'])]
  public function show(Post $post, CommentRepository $commentRepository, Request $request): Response
  {
    if ($post->getValidatedAt() === null) {
      throw $this->createNotFoundException('The post does not exist');
    }
    $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
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
    $mediasListDuration = 0;
    if ($post->getIdMediaslist()) {
      $mediasOfMediasList = $post->getIdMediaslist()->getMedias();
      foreach ($mediasOfMediasList as $media) {
        $mediasListDuration += $media->getDuree();
      }
    }

    $isPostLiked = $post->getUserslike()->contains($this->getUser());

    return $this->render('Front/post/show.html.twig', [
      'post' => $post,
      'form' => $form->createView(),
      'isPostLiked' => $isPostLiked,
      'searchForm' =>  $searchForm->createView(),
      'mediasListDuration' => $mediasListDuration
    ]);
  }

  #[Route('/{id}/like', name: 'app_post_like', methods: ['GET'])]
  public function like(Post $post, PostRepository $postRepository, Request $request): Response
  {
    $referer = $request->headers->get('referer');
    $post->addUserslike($this->getUser());
    $postRepository->save($post, true);

    return $this->redirect($referer);
  }

  #[Route('/{id}/unlike', name: 'app_post_unlike', methods: ['GET'])]
  public function unlike(Post $post, PostRepository $postRepository, Request $request): Response
  {
    $referer = $request->headers->get('referer');
    $post->removeUserslike($this->getUser());
    $postRepository->save($post, true);

    return $this->redirect($referer);
  }

  
}
