<?php

namespace App\Controller\Back;

use App\Entity\EventInvite;
use App\Repository\EventInviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/invite')]
class InviteController extends AbstractController
{   
    #[IsGranted('ROLE_ARTIST')]
    #[Route('/', name: 'app_invite_index', methods: ['GET'])]
    public function index(EventInviteRepository $eventInviteRepository): Response
    {
        $invites = null;
        $artistId = $this->getUser()->getIdArtist();
        $invites = $eventInviteRepository->findBy(['id_artist' => $artistId]);
        
        return $this->render('Back/invite/index.html.twig', [
            'invites' => $invites,
        ]);
    }
}
