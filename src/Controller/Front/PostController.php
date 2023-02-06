<?php

namespace App\Controller\Front;

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
  #[Route('/{slug}', name: 'app_post_show', methods: ['GET'])]
  public function show(Post $post): Response
  {
    return $this->render('Front/post/show.html.twig', [
      'post' => $post,
    ]);
  }
  
}
