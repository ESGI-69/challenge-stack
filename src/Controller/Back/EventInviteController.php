<?php

namespace App\Controller\Back;

use App\Entity\EventInvite;
use App\Repository\EventInviteRepository;
use App\Repository\EventRepository;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/invite')]
class EventInviteController extends AbstractController
{   
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/', name: 'app_invite_index', methods: ['GET'])]
    public function index(EventInviteRepository $eventInviteRepository): Response
    {
        $invites = null;
        $artistId = $this->getUser()->getIdArtist();
        $invites = $eventInviteRepository->findBy(['id_artist' => $artistId, 'status' => 'pending']);
        
        return $this->render('Back/invite/index.html.twig', [
            'invites' => $invites,
        ]);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/new', name: 'app_select_artist_event_invite', methods: ['GET'])]
    public function selectArtistEventInviteIndex(Request $request, EventInviteRepository $eventInviteRepository, ArtistRepository $artistRepository, EventRepository $eventRepository): Response
    {
        $eventSlug = $request->query->get('event');
        $event = $eventRepository->findOneBy(['slug' => $eventSlug]);
        $invitedArtists = [];
        
        $eventInvite = $eventInviteRepository->findBy(['ArtistAuthor' => $this->getUser()->getIdArtist(), 'id_event' => $event]);
        foreach ($eventInvite as $invite) {
            $invitedArtists[] = $invite->getIdArtist();
        }

        $invitesByArtist = [];
        foreach ($invitedArtists as $invitedArtist) {
            $invitesByArtist[$invitedArtist->getId()] = $eventInviteRepository->findOneBy(['id_artist' => $invitedArtist, 'id_event' => $event]);
        }

        $artists = $artistRepository->findExcept([$this->getUser()->getIdArtist()->getId()]);

        return $this->render('Back/invite/invitedUser.html.twig', [
            'event' => $event,
            'artists' => $artists,
            'invitedArtists' => $invitedArtists,
            'eventInvite' => $eventInvite,
            'invitesByArtist' => $invitesByArtist,
        ]);
    }

    #[isGranted('ROLE_ARTIST')]
    #[Route('/send', name: 'app_event_invite_send', methods: ['POST'])]
    public function send(Request $request, EventInviteRepository $eventInviteRepository, EventRepository $eventRepository, ArtistRepository $artistRepository)
    {
        $artistId = $request->query->get('artist');
        $eventId = $request->query->get('event');
        
        $artist = $artistRepository->findOneBy(['id' => $artistId]);
        $event = $eventRepository->findOneBy(['id' => $eventId]);

        if ($event->getArtistAuthor() != $this->getUser()->getIdArtist()) {
            throw $this->createAccessDeniedException();
        }

        // Test if the artist is already invited
        $alreadyInvited = $eventInviteRepository->findOneBy(['id_artist' => $artist, 'id_event' => $event]);
        if ($alreadyInvited) {
            $this->addFlash('danger', 'Cet artiste a déjà été invité');
            return $this->redirectToRoute('admin_app_select_artist_event_invite', ['event' => $event->getSlug()], Response::HTTP_SEE_OTHER);
        }

        // Create a new eventInvite
        $eventInvite = new EventInvite();
        $eventInvite->setIdArtist($artist);
        $eventInvite->setArtistAuthor($this->getUser()->getIdArtist());
        $eventInvite->setIdEvent($event);
        $eventInvite->setStatus('pending');
        $eventInvite->setCreatedAt(new \DateTimeImmutable());
        $eventInvite->setComment('Invitation envoyée zebi');
        $eventInviteRepository->save($eventInvite, true);

        return $this->redirectToRoute('admin_app_select_artist_event_invite', ['event' => $event->getSlug()], Response::HTTP_SEE_OTHER);
    }

    #[isGranted('ROLE_ARTIST')]
    #[Route('/{id}', name: 'app_event_invite_delete', methods: ['POST'])]
    public function delete(Request $request, EventInvite $eventInvite, EventInviteRepository $eventInviteRepository): Response
    {
        if ($eventInvite->getArtistAuthor() != $this->getUser()->getIdArtist()) {
            throw $this->createAccessDeniedException();
        }

        $eventSlug = $request->query->get('event-redirection');

        if ($this->isCsrfTokenValid('delete'.$eventInvite->getId(), $request->request->get('_token'))) {
            $eventInviteRepository->remove($eventInvite, true);
        }

        return $this->redirectToRoute('admin_app_select_artist_event_invite', ['event' => $eventSlug], Response::HTTP_SEE_OTHER);
    }

    #[isGranted('ROLE_ARTIST')]
    #[Route('/accept/{id}', name: 'app_event_invite_accept', methods: ['POST'])]
    public function accept(Request $request, EventInvite $eventInvite, EventInviteRepository $eventInviteRepository): Response
    {

        if ($eventInvite->getIdArtist() != $this->getUser()->getIdArtist()) {
            throw $this->createAccessDeniedException();
        }

        $event = $eventInvite->getIdEvent();
        
        if ($this->isCsrfTokenValid('accept'.$eventInvite->getId(), $request->request->get('_token'))) {
            $event->addArtist($eventInvite->getIdArtist());
            $eventInvite->setStatus('accepted');
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_app_invite_index', [], Response::HTTP_SEE_OTHER);
    }

    #[isGranted('ROLE_ARTIST')]
    #[Route('/decline/{id}', name: 'app_event_invite_decline', methods: ['POST'])]
    public function decline(Request $request, EventInvite $eventInvite, EventInviteRepository $eventInviteRepository): Response
    {

        if ($eventInvite->getIdArtist() != $this->getUser()->getIdArtist()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('decline'.$eventInvite->getId(), $request->request->get('_token'))) {
            $eventInvite->setStatus('declined');
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_app_invite_index', [], Response::HTTP_SEE_OTHER);
    }
}
