<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    #[Route('/', name: 'feed')]
    public function index(): Response
    {
        return $this->render('Front/feed/index.html.twig', [
            'controller_name' => 'FeedController',
        ]);
    }
}
