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

#[Route('/invite')]
class EventInviteController extends AbstractController
{   
    #[IsGranted('ROLE_ARTIST')]
    #[Route('/', name: 'app_invite_index', methods: ['GET'])]
    public function index(EventInviteRepository $eventInviteRepository): Response
    {
        $invites = null;
        $artistId = $this->getUser()->getIdArtist();
        $invites = $eventInviteRepository->findBy(['id_artist' => $artistId]);
        
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

        $artists = $artistRepository->findAll();

        return $this->render('Back/invite/invitedUser.html.twig', [
            'event' => $event,
            'artists' => $artists,
            'invitedArtists' => $invitedArtists,
            'eventInvite' => $eventInvite,
            'invitesByArtist' => $invitesByArtist,
        ]);
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
}
