<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'events')]
    public function index(): Response
    {
        return $this->render('front/events/index.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }
}
