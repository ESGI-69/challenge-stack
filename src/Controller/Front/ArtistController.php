<?php

namespace App\Controller\Front;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/artist')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'app_artist_index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findBy([], ['id' => 'DESC'], 10);
        $queryTrendingArtist = $artistRepository->createQueryBuilder('a')
            ->select('a, COUNT(au.id) as followers')
            ->leftJoin('a.followed', 'au')
            ->groupBy('a.id')
            ->orderBy('followers', 'DESC')
            ->setMaxResults(10)
            ->getQuery();
        $artistsWithTopFollowers = $queryTrendingArtist->getResult();

        return $this->render('Front/artists/index.html.twig', [
            'artists' => $artists,
            'artistsWithTopFollowers' => $artistsWithTopFollowers,
            'controller_name' => 'ArtistController'
        ]);
    }

    #[Route('/new', name: 'app_artist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtistRepository $artistRepository): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->save($artist, true);

            return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artist_show', methods: ['GET'])]
    public function show(Artist $artist): Response
    {
        return $this->render('front/artists/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_artist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->save($artist, true);

            return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artist_delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $artistRepository->remove($artist, true);
        }

        return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
