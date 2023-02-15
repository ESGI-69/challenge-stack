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
        
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        
                if (($form->isSubmitted() && $form->isValid())) {

                    $search = $form->getData();
                    $search = $search['search'];
                
                }else{
                    if ($request->isMethod('POST')) { 
                        
                        if ($this->isCsrfTokenValid('search', $request->request->get('_token'))) {
                            $search = $request->request->get('search') ;
                            $search = htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                        }else{
                            throw new \Exception('CSRF token is invalid');
                        }                       
                    }else{
                        return $this->render('Front/search/index.html.twig', [
                            'form' => $form->createView()
                        ]);
                    }
                }

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
                      'form' => $form->createView()
                  ]);


    }
}
