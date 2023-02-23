<?php

namespace App\Controller\Back;

use App\Entity\Event;
use App\Form\EventType;
use App\Form\EventPrivacyType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('event')]
class EventController extends AbstractController
{
    #[IsGranted('ROLE_ARTIST')]
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        $today = new \DateTime();
        return $this->render('/Back/event/index.html.twig', [
            // All events created by the connected artist
            'events' => $eventRepository->findBy(['ArtistAuthor' => $this->getUser()->getIdArtist()]),
        ]);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/new-event', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EventRepository $eventRepository): Response
    {
        $linkedArtist = true;
        $event = new Event();

        $idArtist = $this->getUser()->getIdArtist();

        if ($idArtist === null) {
          $linkedArtist = false;
        } else {
          $event->addArtist($this->getUser()->getIdArtist());
          $event->setArtistAuthor($this->getUser()->getIdArtist());
        }

        $event->setPrivate(true);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eventRepository->save($event, true);

            return $this->redirectToRoute('admin_app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/event/new.html.twig', [
            'event' => $event,
            'form' => $form,
            'linkedArtist' => $linkedArtist,
        ]);
    }

    #[isGranted('ROLE_ARTIST')]
    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->save($event, true);

            return $this->redirectToRoute('admin_app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Back/event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[isGranted('ROLE_ARTIST')]
    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $eventRepository->remove($event, true);
        }

        return $this->redirectToRoute('admin_app_event_index', [], Response::HTTP_SEE_OTHER);
    }

    // EVENT PRIVACY

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/privacy', name: 'app_event_privacy_index', methods: ['GET'])]
    public function privacy(EventRepository $eventRepository): Response
    {
        $today = new \DateTime();
        return $this->render('/Back/event/privacy/index.html.twig', [
            // All events created by the connected artist
            'events' => $eventRepository->findBy(['ArtistAuthor' => $this->getUser()->getIdArtist()]),
        ]);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/privacy/{slug}/edit', name: 'app_event_privacy_edit', methods: ['GET', 'POST'])]
    public function privacyEdit(Request $request, Event $event, EventRepository $eventRepository): Response
    {

        $form = $this->createForm(EventPrivacyType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->save($event, true);

            return $this->redirectToRoute('admin_app_event_privacy_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $today = new \DateTime();

        return $this->renderForm('/Back/event/privacy/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }
}
