<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user', methods: ['GET', 'POST']) ]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $users = $userRepository->findAll();
        // $user = $userRepository->search($request);
        return $this->render('back/user/index.html.twig', [
            'users' => $users,
            // 'user' => $user
        ]);
    }
}
