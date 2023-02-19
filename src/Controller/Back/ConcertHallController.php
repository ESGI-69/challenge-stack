<?php

namespace App\Controller\Back;

use App\Entity\ConcertHall;
use App\Form\ConcertHallType;
use App\Repository\ConcertHallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/club')]
class ConcertHallController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_club_index', methods: ['GET'])]
    public function index(ConcertHallRepository $concertHallRepository): Response
    {
        return $this->render('Back/club/index.html.twig', [
            'clubs' => $concertHallRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConcertHallRepository $concertHallRepository): Response
    {
        $concertHall = new ConcertHall();
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                //Get the adress geolocation using nominatim
            $address = $form->get('address')->getData();
            $city = $form->get('city')->getData();
            $urlencode = rawurlencode($address . ' ' . $city);

            $url = 'https://nominatim.openstreetmap.org/search?q=' . $urlencode . '&format=json';
            $opts = [
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'User-Agent: PHP'
                    ]
                ]
            ];

            $context = stream_context_create($opts);
            $response = file_get_contents($url, false, $context);
            $result = json_decode($response);

            if(empty($result)) {
                $this->addFlash('danger', 'Adresse non trouvée');
            }else{
                $latitude = $result[0]->lat;
                $longitude = $result[0]->lon;
                $location = [
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ];
                $concertHall->setLocation($location); 
            }
     
            $concertHallRepository->save($concertHall, true);
            return $this->redirectToRoute('admin_app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/club/new.html.twig', [
            'club' => $concertHall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_club_show', methods: ['GET'])]
    public function show(ConcertHall $concertHall): Response
    {
        return $this->render('Back/club/show.html.twig', [
            'club' => $concertHall,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertHallRepository->save($concertHall, true);

            return $this->redirectToRoute('admin_app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/club/edit.html.twig', [
            'club' => $concertHall,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_club_delete', methods: ['POST'])]
    public function delete(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concertHall->getId(), $request->request->get('_token'))) {
            $concertHallRepository->remove($concertHall, true);
        }

        return $this->redirectToRoute('admin_app_club_index', [], Response::HTTP_SEE_OTHER);
    }
}
