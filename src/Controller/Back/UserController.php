<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\RoleType;
use App\Form\RoleManagerType;
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
    public function index(UserRepository $userRepository, Request $request): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
          $users = $userRepository->findAll();
          return $this->render('back/user/index.html.twig', [
              'users' => $users,
          ]);
        } elseif ($this->isGranted('ROLE_MANAGER') && !$this->isGranted('ROLE_ADMIN')){
          $users = $userRepository->findAll();
          foreach ($users as $key => $user) {
            if (in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_MANAGER', $user->getRoles())) {
              unset($users[$key]);
            }
          }
          return $this->render('back/user/index.html.twig', [
              'users' => $users,
          ]);
        }
    }

    /**
     * @param User $user
     * @return Response
     */
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
          $form = $this->createForm(RoleType::class, $user);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              $userRepository->save($user, true);
              return $this->redirectToRoute('admin_user_index');
          }
        } elseif ($this->isGranted('ROLE_MANAGER') && !$this->isGranted('ROLE_ADMIN')){
          $form = $this->createForm(RoleManagerType::class, $user);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              $userRepository->save($user, true);
              return $this->redirectToRoute('admin_user_index');
          }
        }

        return $this->render('back/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
