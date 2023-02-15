<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Artist;
use App\Entity\ConcertHall;
use app\Entity\Event;
use App\Form\SearchType;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET', 'POST'])]
    public function search(Request $request, ManagerRegistry $doctrine): Response
    {
        
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $search = $search['search'];

            // search in the database for artist name
            $artistRepository = $doctrine->getRepository(Artist::class);
            $artists = $artistRepository->findBy(['pseudo' => $search]);
            // search in the database for concert hall name
            $concertHallRepository = $doctrine->getRepository(ConcertHall::class);
            $concertHalls = $concertHallRepository->findBy(['name' => $search]);
            // search in the database for event name
            $eventRepository = $doctrine->getRepository(Event::class);
            $events = $eventRepository->findBy(['title' => $search]);

            
            return $this->render('Front/search/index.html.twig', [
                'search' => $search,
                'artists' => $artists,
                'concertHalls' => $concertHalls,
                'events' => $events,
                'form' => $form->createView()
            ]);
        }
        
        return $this->render('Front/search/index.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
