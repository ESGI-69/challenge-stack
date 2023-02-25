<?php

namespace App\Controller\Back;

use App\Entity\Media;
use App\Entity\User;
use App\Repository\MediaRepository;
use App\Form\MediaBackType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/media')]
class MediaController extends AbstractController
{
  #[IsGranted('ROLE_ARTIST')]
  #[Route('/', name: 'app_media_index', methods: ['GET'])]
  public function index(MediaRepository $mediaRepository): Response
  {
      $medias = null;
      $artistLinked = false;
      if ($this->getUser()->getIdArtist()){
        $medias = $mediaRepository->mediaByArtist($this->getUser()->getIdArtist()->getId());
        $artistLinked = true;
      }
      return $this->render('Back/media/index.html.twig', [
          'medias' => $medias,
          'artistLinked' => $artistLinked,
      ]);
  }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('{id}',  name: 'app_media_delete', methods: ['POST'])]
  public function delete(Request $request, Media $media, MediaRepository $mediaRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$media->getId(), $request->request->get('_token'))) {
            $mediaRepository->remove($media, true);
        }

        return $this->redirectToRoute('admin_app_media_index', [], Response::HTTP_SEE_OTHER);
    }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('/new', name: 'app_media_new', methods: ['GET', 'POST'])]
  public function new(Request $request, MediaRepository $mediaRepository): Response
  {
    $linkedArtist = true;
      $idArtist = $this->getUser()->getIdArtist();
      if ($idArtist === null) {
        $linkedArtist = false;
    }
    $media = new Media();
    // dd($media);
    $form = $this->createForm(MediaBackType::class, $media);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $media->addArtist($this->getUser()->getIdArtist());
      $mediaRepository->save($media, true);

      return $this->redirectToRoute('admin_app_media_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/media/new.html.twig', [
      'media' => $media,
      'form' => $form,
      'linkedArtist' => $linkedArtist,
    ]);
  }
  #[IsGranted('ROLE_ARTIST')]
  #[Route('/{id}/edit', name: 'app_media_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Media $media, MediaRepository $mediaRepository): Response
  {
    $idArtist = $this->getUser()->getIdArtist();
    $artistArray = $media->getArtists();
    if (!in_array($idArtist, $artistArray->toArray())) {
      return $this->redirectToRoute('admin_app_media_index', [], Response::HTTP_SEE_OTHER);
    }
    $form = $this->createForm(MediaBackType::class, $media);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $mediaRepository->save($media, true);

      return $this->redirectToRoute('admin_app_media_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/media/edit.html.twig', [
      'media' => $media,
      'form' => $form,
    ]);
  }
}