<?php

namespace App\Controller\Front;

use App\Entity\ConcertHall;
use App\Form\ConcertHallType;
use App\Repository\ConcertHallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;


#[Route('/club')]
class ConcertHallController extends AbstractController
{
    #[Route('/', name: 'app_club_index', methods: ['GET'])]
    public function index(ConcertHallRepository $concertHallRepository): Response
    {        
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/club/index.html.twig', [
            'clubs' => $concertHallRepository->getLastCreate(3),
            'clubsWithTopEvents' => $concertHallRepository->getTrendingConcertHalls(),
            'searchForm' => $searchForm->createView()
        ]);
    }

    #[Route('/new', name: 'app_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConcertHallRepository $concertHallRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
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
            'searchForm' => $searchForm->createView()
        ]);
    }

    #[Route('/{slug}', name: 'app_club_show', methods: ['GET'])]
    public function show(ConcertHall $concertHall): Response
    {
        $users = $concertHall->getUsers();

        $followerCount = count($users);
        $isFollowed = null;

        if ( !is_null($this->getUSer()) && count($users)>0 ) {
            foreach ($users as $user) {
                if ( $user->getId() == $this->getUser()->getId() ) {
                    $isFollowed = true;
                }
            }
        }

        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/club/show.html.twig', [
            'club' => $concertHall,
            'searchForm' => $searchForm->createView(),
            'followerCount' => $followerCount,
            'isFollowed' => $isFollowed,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $form = $this->createForm(ConcertHallType::class, $concertHall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertHallRepository->save($concertHall, true);

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('club/edit.html.twig', [
            'club' => $concertHall,
            'form' => $form,
            'searchForm' => $searchForm->createView()
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

    #[Route('/{id}/follow', name: 'app_concerthall_follow', methods: ['GET'])]
    public function follow(ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        $concertHall->addUser($this->getUser());
        $concertHallRepository->save($concertHall, true);
        return $this->redirectToRoute('front_app_club_show', ['slug' => $concertHall->getSlug()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/unfollow', name: 'app_concerthall_unfollow', methods: ['GET'])]
    public function unfollow(ConcertHall $concertHall, ConcertHallRepository $concertHallRepository): Response
    {
        $concertHall->removeUser($this->getUser());
        $concertHallRepository->save($concertHall, true);
        return $this->redirectToRoute('front_app_club_show', ['slug' => $concertHall->getSlug()], Response::HTTP_SEE_OTHER);
    }
}
