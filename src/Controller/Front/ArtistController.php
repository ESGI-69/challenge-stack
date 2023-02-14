<?php

namespace App\Controller\Front;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use App\Repository\PostRepository;
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
        return $this->render('Front/artist/index.html.twig', [
            'artists' => $artistRepository->getLastCreate(5),
            'artistsWithTopFollowers' => $artistRepository->getTrending(5),
            'controller_name' => 'ArtistController'
        ]);
    }

    /**
     * @param Artist $artist
     * @return Response
     */
    #[Route('/{slug}', name: 'app_artist_show', methods: ['GET'])]
    public function show(Artist $artist, ArtistRepository $artistRepository, PostRepository $PostRepository): Response
    {
        $followerCount = $artistRepository->getFollowersCount($artist->getId());
        
        $isFollowed = null;
        if ($this->getUser() !== null){
          $isFollowed = $artistRepository->isFollowed($artist->getId(), $this->getUser()->getId());
        }
        return $this->render('Front/artist/show.html.twig', [
            'artist' => $artist,
            'followerCount' => $followerCount,
            'isFollowed' => $isFollowed,
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

    #[Route('/{id}/follow', name: 'app_artist_follow', methods: ['GET'])]
    public function follow(Artist $artist, ArtistRepository $artistRepository): Response
    {
        $artist->addFollowed($this->getUser());
        $artistRepository->save($artist, true);
        return $this->redirectToRoute('front_app_artist_show', ['slug' => $artist->getSlug()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/unfollow', name: 'app_artist_unfollow', methods: ['GET'])]
    public function unfollow(Artist $artist, ArtistRepository $artistRepository): Response
    {
        $artist->removeFollowed($this->getUser());
        $artistRepository->save($artist, true);
        return $this->redirectToRoute('front_app_artist_show', ['slug' => $artist->getSlug()], Response::HTTP_SEE_OTHER);
    }

}
