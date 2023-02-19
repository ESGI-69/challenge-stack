<?php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;


#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $today = new \DateTime();
        return $this->render('Front/event/index.html.twig', [
            'events' => $eventRepository->getEventByDate($today),
            'tomorrowEvents' => $eventRepository->getEventByDate($today->modify('+1 day')),
            'searchForm' => $searchForm->createView()
        ]);
    }

    #[Route('/{slug}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/event/show.html.twig', [
            'event' => $event,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
