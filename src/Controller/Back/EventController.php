<?php

namespace App\Controller\Back;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    // #[Route('/', name: 'app_event_index', methods: ['GET'])]
    // public function index(EventRepository $eventRepository): Response
    // {
    //     $today = new \DateTime();
    //     return $this->render('Front/event/index.html.twig', [
    //         'events' => $eventRepository->getEventByDate($today),
    //         'tomorrowEvents' => $eventRepository->getEventByDate($today->modify('+1 day'))

    //     ]);
    // }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/new-event', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EventRepository $eventRepository): Response
    {
        $event = new Event();
        $event->addArtist($this->getUser()->getIdArtist());
        $event->setPrivate(true);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->save($event, true);

            return $this->redirectToRoute('admin_default_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }
}
