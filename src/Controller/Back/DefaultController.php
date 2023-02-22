<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\EventInviteRepository;

class DefaultController extends AbstractController
{
    #[IsGranted('ROLE_HAS_ACCES_TO_ADMIN_PANNEL')]
    #[Route('/', name: 'default_index')]
    public function index(EventInviteRepository $eventInviteRepository): Response
    {
        $countInvites = 0;
        $user = $this->getUser();
        $artist = $user->getIdArtist();
        if ($artist) {
          $artistId = $artist->getId();
          $invites = $eventInviteRepository->findBy(['id_artist' => $artistId, 'status' => 'pending']);
          $countInvites = count($invites);
        } 
        return $this->render('Back/default/index.html.twig', [
            'controller_name' => 'BackController',
            'user' => $user,
            'countInvites' => $countInvites
        ]);
    }
}
