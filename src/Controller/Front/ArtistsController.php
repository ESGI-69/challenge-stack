<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;
use App\Repository\ArtistRepository;

class ArtistsController extends AbstractController
{
    #[Route('/artists', name: 'artists')]
    public function index(ArtistRepository $repository): Response
    {
        $artists = $repository->findBy([], ['id' => 'DESC'], 10);
        $query = $repository->createQueryBuilder('a')
        ->select('a, COUNT(au.id) as followers')
        ->leftJoin('a.followed', 'au')
        ->groupBy('a.id')
        ->orderBy('followers', 'DESC')
        ->setMaxResults(10)
        ->getQuery();
        $artistsWithTopFollowers = $query->getResult();

        return $this->render('front/artists/index.html.twig', [
            'controller_name' => 'ArtistsController',
            'artists' => $artists,
            'artistsWithTopFollowers' => $artistsWithTopFollowers
        ]);
    }

    #[Route('/artist/{id}', name: 'artist')]
    public function show(Artist $artist): Response
    {
        return $this->render('front/artists/show.html.twig', [
            'artist' => $artist,
        ]);
    }
}
