<?php

namespace App\Controller\Front;

use App\Entity\ConcertHall;
use App\Form\ConcertHallType;
use App\Repository\ConcertHallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/club')]
class ConcertHallController extends AbstractController
{
    #[Route('/', name: 'app_club_index', methods: ['GET'])]
    public function index(ConcertHallRepository $concertHallRepository): Response
    {        
        return $this->render('Front/club/index.html.twig', [
            'clubs' => $concertHallRepository->getLastCreate(3),
            'clubsWithTopEvents' => $concertHallRepository->getTrendingConcertHalls()
        ]);
    }

    #[Route('/new', name: 'app_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConcertHallRepository $concertHallRepository): Response
    {
        $concertHall = new ConcertHall();
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertHallRepository->save($concertHall, true);

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('club/new.html.twig', [
            'club' => $concertHall,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_club_show', methods: ['GET'])]
    public function show(ConcertHall $concertHall): Response
    {
        return $this->render('Front/club/show.html.twig', [
            'club' => $concertHall,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertHallRepository->save($concertHall, true);

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('club/edit.html.twig', [
            'club' => $concertHall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_club_delete', methods: ['POST'])]
    public function delete(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concertHall->getId(), $request->request->get('_token'))) {
            $concertHallRepository->remove($concertHall, true);
        }

        return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
    }
}
