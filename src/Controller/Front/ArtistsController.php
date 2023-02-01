<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistsController extends AbstractController
{
    #[Route('/artists', name: 'artists')]
    public function index(): Response
    {
        return $this->render('front/artists/index.html.twig', [
            'controller_name' => 'ArtistsController',
        ]);
    }
}
