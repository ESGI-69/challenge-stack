<?php

namespace App\Controller\Front;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index')]
    public function index(PostRepository $PostRepository): Response
    {
        $posts;
        if ($this->getUser()) {
            $posts = $PostRepository->getFollowedArtistPosts($this->getUser());
        } else {
            $posts = $PostRepository->getLastCreate();
        }
        return $this->render('Front/feed/index.html.twig', [
            'controller_name' => 'FrontController',
            'posts' => $posts,
        ]);
    }
}
