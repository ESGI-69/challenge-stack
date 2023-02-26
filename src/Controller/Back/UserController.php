<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\RoleType;
use App\Form\RoleManagerType;
use App\Form\UserLinkArtistType;
use App\Form\UserLinkArtistManagerType;
use App\Repository\ArtistRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/user')]

class UserController extends AbstractController
{
    #[IsGranted('ROLE_MANAGER')]
     /**
     * @param  UserRepository  $userRepository
     * @return Response
     */
    #[Route('/', name: 'user_index', methods: ['GET', 'POST']) ]
    public function index(UserRepository $userRepository, ArtistRepository $artistRepository, Request $request): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
          $users = $userRepository->findUsersWithArtist();
          return $this->render('Back/user/index.html.twig', [
              'users' => $users,
          ]);
        } elseif ($this->isGranted('ROLE_MANAGER') && !$this->isGranted('ROLE_ADMIN')){
          $users = $userRepository->findUsersWithArtist();

          $artists = $artistRepository->findByIdManager($this->getUser()->getId());

          $tab_id_artist = [];

          foreach ($artists as $artist) {
            $tab_id_artist[] = $artist->getId();
          }

          $tmp_users = $userRepository->getByListIdArtist($tab_id_artist);

          foreach ($tmp_users as $tmp_user) {
            if ( !in_array($tmp_user, $users) ) {
              $users[] = $tmp_user;
            }
          }

          foreach ($users as $key => $user) {

            if ($user->getIdArtist() !== null && $user->getIdArtist()->getManager()->getId() !== $this->getUser()->getId()) {
              unset($users[$key]);
            }
          }
          foreach ($users as $key => $user) {
            if (in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_MANAGER', $user->getRoles())|| in_array('ROLE_MODERATOR', $user->getRoles())) {
              unset($users[$key]);
            }
          }
          return $this->render('Back/user/index.html.twig', [
              'users' => $users,
          ]);
        }
    }

    /**
     * @param User $user
     * @return Response
     */
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function create(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
          if ($user->getId() === $this->getUser()->getId()) {
            $this->addFlash('danger', 'You can\'t edit yourself');
            return $this->redirectToRoute('admin_user_index');
          } else {
            $form = $this->createForm(RoleType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $userRepository->save($user, true);
                return $this->redirectToRoute('admin_user_index');
            }
          }
        } elseif ($this->isGranted('ROLE_MANAGER') && !$this->isGranted('ROLE_ADMIN')){
          if (in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_MANAGER', $user->getRoles())) {
            $this->addFlash('danger', 'You can\'t edit this user');
            return $this->redirectToRoute('admin_user_index');
          } elseif ($user->getIdArtist() !== null && $this->getUser()->getIdArtist()->getId() !== $user->getIdArtist()->getId()){
            $this->addFlash('danger', 'You can\'t edit this user');
            return $this->redirectToRoute('admin_user_index');
          } else {
            $form = $this->createForm(RoleManagerType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $userRepository->save($user, true);
                if (count($user->getRoles()) <= 1) {
                  $userRepository->unlinkArtist($user->getId());
                }
                return $this->redirectToRoute('admin_user_index');
            }
          }
        }

        return $this->render('Back/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/artist/{id}/link/', name: 'user_artist_link', methods: ['GET', 'POST'])]
    public function linkArtist(Request $request, UserRepository $userRepository, ArtistRepository $artistRepository, User $user): Response
    {

      if (in_array('ROLE_MANAGER', $user->getRoles()) || in_array('ROLE_ARTIST', $user->getRoles())) {
        if ($this->isGranted('ROLE_ADMIN')) {
          $form = $this->createForm(UserLinkArtistType::class, $user);
        } elseif ($this->isGranted('ROLE_MANAGER') && !$this->isGranted('ROLE_ADMIN')){

          $artists = $artistRepository->findByIdManager($this->getUser()->getId());

          $id_artists = [];
          foreach ($artists as $artist) {
            $id_artists[] = $artist->getId();
          }

          $form = $this->createForm(UserLinkArtistManagerType::class, $user, [
            'idArtist' => $id_artists
          ]);

        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            return $this->redirectToRoute('admin_user_index');
        }
      } else {
        $this->addFlash('danger', 'You can\'t link an artist to this user');
        return $this->redirectToRoute('admin_user_index');
      }

      return $this->render('Back/user/link-artist.html.twig', [
          'user' => $user,
          'form' => $form->createView(),
          'artistLinked' => true
      ]);
    }
}
