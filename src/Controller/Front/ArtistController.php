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
use App\Form\SearchType;


#[Route('/artist')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'app_artist_index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/artist/index.html.twig', [
            'artists' => $artistRepository->getLastCreate(5),
            'artistsWithTopFollowers' => $artistRepository->getTrending(5),
            'controller_name' => 'ArtistController',
            'searchForm' => $searchForm->createView()

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
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $isFollowed = null;
        if ($this->getUser() !== null){
          $isFollowed = $artistRepository->isFollowed($artist->getId(), $this->getUser()->getId());
        }
        return $this->render('Front/artist/show.html.twig', [
            'artist' => $artist,
            'followerCount' => $followerCount,
            'isFollowed' => $isFollowed,
            'searchForm' => $searchForm->createView()
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

    #[Route('/{id}/follow', name: 'app_artist_follow', methods: ['POST'])]
    public function follow(Artist $artist, ArtistRepository $artistRepository, Request $request): Response
    {
        if(!$this->isCsrfTokenValid('follow_artist', $request->request->get('_token'))){
            throw new \Exception('Invalid CSRF token');
        }
        $artist->addFollowed($this->getUser());
        $artistRepository->save($artist, true);
        return $this->redirectToRoute('front_app_artist_show', ['slug' => $artist->getSlug()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/unfollow', name: 'app_artist_unfollow', methods: ['POST'])]
    public function unfollow(Artist $artist, ArtistRepository $artistRepository, Request $request): Response
    {
        //check csrf
        if(!$this->isCsrfTokenValid('unfollow_artist', $request->request->get('_token'))){
            throw new \Exception('Invalid CSRF token');
        }
        $artist->removeFollowed($this->getUser());
        $artistRepository->save($artist, true);
        return $this->redirectToRoute('front_app_artist_show', ['slug' => $artist->getSlug()], Response::HTTP_SEE_OTHER);
    }

}
