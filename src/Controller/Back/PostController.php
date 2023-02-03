<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
  #[IsGranted('ROLE_MANAGER')]
  #[Route('/post-validation', name: 'validate_post')]
  public function index(PostRepository $postRepository): Response
  {
    // get artist id linked to the current user
    $artistId = $this->getUser()->getIdArtist()->getId();
    // All unvalidated posts ID from the artist
    $unvalidatedPostIds = $postRepository->getUnvalidatedPostIdsFromArtist($artistId);
    // Retrive all unvalidated posts from the artist
    foreach ($unvalidatedPostIds as $unvalidatedPostId) {
      $unvalidatedPosts[] = $postRepository->find($unvalidatedPostId);
    }

    return $this->render('Back/post/validation.html.twig', [
        'unvalidatedPosts' => $unvalidatedPosts,
    ]);
  }
}
