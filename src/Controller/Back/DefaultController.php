<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\EventInviteRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

class DefaultController extends AbstractController
{
    #[IsGranted('ROLE_HAS_ACCES_TO_ADMIN_PANNEL')]
    #[Route('/', name: 'default_index')]
    public function index(EventInviteRepository $eventInviteRepository, CommentRepository $commentRepository, PostRepository $postRepository): Response
    {
        $countInvites = 0;
        $user = $this->getUser();
        $artist = $user->getIdArtist();
        if ($artist) {
          $artistId = $artist->getId();
          $invites = $eventInviteRepository->findBy(['id_artist' => $artistId, 'status' => 'pending']);
          $countInvites = count($invites);
        }

        $countComment = 0;
        $comments = $commentRepository->findBy(['validated_at' => null]);
        $countComment = count($comments);

        $countPost = 0;
        if ($artist) {
          $artistId = $artist->getId();
          $posts = $postRepository->findBy(['id_artist' => $artistId, 'validated_at' => null]);
          $countPost = count($posts);
        }

        $artistName = null;
        if ($artist){
          $artistName = $artist->getPseudo();
        } 

        return $this->render('Back/default/index.html.twig', [
            'controller_name' => 'BackController',
            'user' => $user,
            'countInvites' => $countInvites,
            'countComment' => $countComment,
            'countPost' => $countPost,
            'artistName' => $artistName
        ]);
    }
}
