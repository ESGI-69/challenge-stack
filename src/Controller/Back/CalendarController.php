<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\EventInviteRepository;
use App\Repository\EventRepository;

class CalendarController extends AbstractController
{
  #[IsGranted('ROLE_ARTIST')]
  #[Route('/calendar', name: 'app_calendar_index')]
  public function index(Request $request, EventInviteRepository $eventInviteRepository, EventRepository $eventRepository): Response
  {
    $from = $request->query->get('from');
    $to = $request->query->get('to');
    $fromDate = $from ? new \DateTimeImmutable($from) : null;
    $toDate = $to ? new \DateTime($to) : null;
    // Redirect on dashboard if no date is set
    if (!$fromDate || !$toDate) {
      return $this->redirectToRoute('admin_default_index');
    }
    $currentWeek = [
      'from' => $fromDate->format('c'),
      'to' => $toDate->format('c'),
    ];
    $nextWeek = [
      'from' => (new \DateTime($from))->modify('+1 week')->format('c'),
      'to' => (new \DateTime($to))->modify('+1 week')->format('c'),
    ];
    $prevWeek = [
      'from' => (new \DateTime($from))->modify('-1 week')->format('c'),
      'to' => (new \DateTime($to))->modify('-1 week')->format('c'),
    ];

    // Get all my event artist events
    $events = $eventRepository->findBy(['ArtistAuthor' => $this->getUser()->getIdArtist()]);
    $invites = $eventInviteRepository->findBy(['id_artist' => $this->getUser()->getIdArtist(), 'status' => 'accepted']);
    $pendingInvites = $eventInviteRepository->findBy(['id_artist' => $this->getUser()->getIdArtist(), 'status' => 'pending']);
    $eventsInvite;
    foreach($invites as $invite) {
      $event = $invite->getIdEvent();
      $event->inviteStatus = $invite->getStatus();
      $eventsInvite[] = $event;
    }
    foreach($pendingInvites as $invite) {
      $event = $invite->getIdEvent();
      $event->inviteStatus = $invite->getStatus();
      $eventsInvite[] = $event;
    }

    $allEvents = array_merge($events, $eventsInvite ?? []);

    return $this->render('Back/calendar/index.html.twig', [
      'currentWeek' => $currentWeek,
      'nextWeek' => $nextWeek,
      'prevWeek' => $prevWeek,
      'events' => $allEvents,
    ]);
  }
}
