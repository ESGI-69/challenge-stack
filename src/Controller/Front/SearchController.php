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
use Symfony\Component\Security\Csrf\Exception\InvalidCsrfTokenException;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET', 'POST'])]
    public function search(Request $request, ManagerRegistry $doctrine): Response
    {
        
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

                if (($searchForm->isSubmitted() && $searchForm->isValid())) {

                    $search = $searchForm->getData();
                    $search = $search['search'];

                    $artistRepository = $doctrine->getRepository(Artist::class);
                    $artists = $artistRepository->findBy(['pseudo' => $search]);

                    $concertHallRepository = $doctrine->getRepository(ConcertHall::class);
                    $concertHalls = $concertHallRepository->findBy(['name' => $search]);

                    $eventRepository = $doctrine->getRepository(Event::class);
                    $events = $eventRepository->findBy(['title' => $search]);
                    
                    return $this->render('Front/search/index.html.twig', [
                        'search' => $search,
                        'artists' => $artists,
                        'concertHalls' => $concertHalls,
                        'events' => $events,
                        'searchForm' => $searchForm->createView()
                    ]);
                    

                }else{
                    return $this->render('Front/search/index.html.twig', [
                        'searchForm' => $searchForm->createView()
                    ]);
                }

    }
}
