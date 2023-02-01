<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubsController extends AbstractController
{
    #[Route('/clubs', name: 'clubs')]
    public function index(): Response
    {
        return $this->render('front/clubs/index.html.twig', [
            'controller_name' => 'ClubsController',
        ]);
    }
}
