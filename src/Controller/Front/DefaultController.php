<?php

namespace App\Controller\Front;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  App\Form\SearchType;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index')]
    public function index(PostRepository $PostRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);

        $posts = null;
        if ($this->getUser()) {
            $posts = $PostRepository->getFollowedArtistPosts($this->getUser());
        } else {
            $posts = $PostRepository->getLastCreate();
        }
        return $this->render('Front/feed/index.html.twig', [
            'controller_name' => 'FrontController',
            'posts' => $posts,
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
