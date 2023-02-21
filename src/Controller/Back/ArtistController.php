<?php

namespace App\Controller\Back;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/artist')]
class ArtistController extends AbstractController
{
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/', name: 'app_artist_index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('Back/artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/new', name: 'app_artist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtistRepository $artistRepository): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->save($artist, true);

            return $this->redirectToRoute('admin_app_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}', name: 'app_artist_show', methods: ['GET'])]
    public function show(Artist $artist): Response
    {
        return $this->render('Back/artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}/edit', name: 'app_artist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->save($artist, true);

            return $this->redirectToRoute('admin_app_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}', name: 'app_artist_delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $artistRepository->remove($artist, true);
        }

        return $this->redirectToRoute('admin_app_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
