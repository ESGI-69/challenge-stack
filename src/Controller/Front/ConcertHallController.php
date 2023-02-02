<?php

namespace App\Controller\Front;

use App\Entity\ConcertHall;
use App\Form\ConcertHallType;
use App\Repository\ConcertHallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/concert/hall')]
class ConcertHallController extends AbstractController
{
    #[Route('/', name: 'app_concert_hall_index', methods: ['GET'])]
    public function index(ConcertHallRepository $concertHallRepository): Response
    {
        return $this->render('Front/concert_hall/index.html.twig', [
            'concert_halls' => $concertHallRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_concert_hall_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConcertHallRepository $concertHallRepository): Response
    {
        $concertHall = new ConcertHall();
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertHallRepository->save($concertHall, true);

            return $this->redirectToRoute('app_concert_hall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('concert_hall/new.html.twig', [
            'concert_hall' => $concertHall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_concert_hall_show', methods: ['GET'])]
    public function show(ConcertHall $concertHall): Response
    {
        return $this->render('Front/concert_hall/show.html.twig', [
            'concert_hall' => $concertHall,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_concert_hall_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertHallRepository->save($concertHall, true);

            return $this->redirectToRoute('app_concert_hall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('concert_hall/edit.html.twig', [
            'concert_hall' => $concertHall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_concert_hall_delete', methods: ['POST'])]
    public function delete(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concertHall->getId(), $request->request->get('_token'))) {
            $concertHallRepository->remove($concertHall, true);
        }

        return $this->redirectToRoute('app_concert_hall_index', [], Response::HTTP_SEE_OTHER);
    }
}
