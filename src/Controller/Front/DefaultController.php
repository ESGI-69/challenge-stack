<?php

namespace App\Controller\Front;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Serializer\SerializerInterface;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DefaultController extends AbstractController
{
    // #[IsGranted('ROLE_VALIDATOR')]
    #[Route('/', name: 'default_index')]
    public function index(PostRepository $PostRepository): Response
    {
        return $this->render('Front/feed/index.html.twig', [
            'controller_name' => 'FrontController',
            'posts' => $PostRepository->getLastCreate(5),
        ]);
    }
}
