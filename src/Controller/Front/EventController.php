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
            'events' => $eventRepository->getPublicEventByDate((new \DateTime())),
            'tomorrowEvents' => $eventRepository->getPublicEventByDate((new \DateTime())->modify('+1 day')),
            'monthEvents' => $eventRepository->getPublicEventByDateRange((new \DateTime()), (new \DateTime())->modify('+1 month')),
            'passedEvents' => $eventRepository->getPublicEventsBeforeDate(new \DateTime()),
            'searchForm' => $searchForm->createView()
        ]);
    }

    #[Route('/{slug}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        // if event private raise 404
        if($event->isPrivate()){
            throw $this->createNotFoundException('The event does not exist');
        }
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/event/show.html.twig', [
            'event' => $event,
            'searchForm' => $searchForm->createView()
        ]);
    }

    //route to make a user be interested in an event
    #[Route('/{id}/interested', name: 'app_event_interested', methods: ['POST'])]
    public function interested(Event $event, EventRepository $eventRepository , Request $request): Response
    {
        // check csrf token 
        if (!$this->isCsrfTokenValid('interested', $request->request->get('_token'))) {
            return $this->redirectToRoute('front_app_event_show', ['slug' => $event->getSlug()], Response::HTTP_SEE_OTHER);
        }else{
            $event->addInsterestedUser($this->getUser());
            $eventRepository->save($event, true);
            return $this->redirectToRoute('front_app_event_show', ['slug' => $event->getSlug()], Response::HTTP_SEE_OTHER);
        }
       
    }

    //route to make a user be not interested in an event
    #[Route('/{id}/uninterested', name: 'app_event_uninterested', methods: ['POST'])]
    public function uninterested(Event $event, EventRepository $eventRepository, Request $request): Response
    {
        // check csrf token
        if (!$this->isCsrfTokenValid('interested', $request->request->get('_token'))) {
            return $this->redirectToRoute('front_app_event_show', ['slug' => $event->getSlug()], Response::HTTP_SEE_OTHER);
        }else{
            $event->removeInsterestedUser($this->getUser());
            $eventRepository->save($event, true);
            return $this->redirectToRoute('front_app_event_show', ['slug' => $event->getSlug()], Response::HTTP_SEE_OTHER);
        }
     
    }


}
