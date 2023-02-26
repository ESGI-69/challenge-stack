<?php

namespace App\Controller\Back;

use App\Entity\MediasList;
use App\Entity\Media;
use App\Entity\User;
use App\Repository\MediasListRepository;
use App\Repository\MediaRepository;
use App\Form\MediasListBackType;
use App\Form\MediaSelectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/mediasList')]
class MediasListController extends AbstractController
{
  #[IsGranted('ROLE_ARTIST')]
  #[Route('/', name: 'app_mediaslist_index', methods: ['GET'])]
  public function index(MediasListRepository $mediasListRepository): Response
  {
      $mediaslists = null;
      $artistLinked = false;
      if ($this->getUser()->getIdArtist()){
        $mediaslists = $mediasListRepository->mediasListsByArtist($this->getUser()->getIdArtist()->getId());
        $artistLinked = true;
      }
      return $this->render('Back/mediasList/index.html.twig', [
          'mediasLists' => $mediaslists,
          'artistLinked' => $artistLinked,
      ]);
  }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('/new', name: 'app_mediaslist_new', methods: ['GET', 'POST'])]
  public function new(Request $request, MediasListRepository $mediasListRepository): Response
  {
    $linkedArtist = true;
    $idArtist = $this->getUser()->getIdArtist();
    if ($idArtist === null) {
        $linkedArtist = false;
    }

    $mediasList = new MediasList();
    $form = $this->createForm(MediasListBackType::class, $mediasList);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $mediasList->addArtist($this->getUser()->getIdArtist());
      $mediasListRepository->save($mediasList, true);

      return $this->redirectToRoute('admin_app_mediaslist_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/mediasList/new.html.twig', [
      'mediasList' => $mediasList,
      'form' => $form,
      'linkedArtist' => $linkedArtist,
    ]);
  }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('/medias/{id}', name: 'app_mediaslist_medias', methods: ['GET'])]
  public function medias(MediasList $mediasList, $id): Response
  {
    $linkedArtist = true;
    $idArtist = $this->getUser()->getIdArtist();
    if ($idArtist === null) {
        $linkedArtist = false;
    }

    $medias = $mediasList->getMedias();
    return $this->render('Back/mediasList/medias.html.twig', [
        'medias' => $medias,
        'artistLinked' => $linkedArtist,
        'id' => $id,
        'mediasList' => $mediasList,
    ]);
  }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('/medias/{id}/add', name: 'app_mediaslist_add_media', methods: ['GET', 'POST'])]
  public function addMedia(MediasList $mediasList, MediasListRepository $mediasListRepository, MediaRepository $mediaRepository, Request $request): Response
  {
    $linkedArtist = true;
    $idArtist = $this->getUser()->getIdArtist();
    if ($idArtist === null) {
        $linkedArtist = false;
    }

    $medias = $mediaRepository->mediaByArtist($idArtist->getId());

    $form = $this->createForm(MediaSelectType::class, null, ['medias' => $medias]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $selectedMedia = $form->get('medias')->getData();
        $mediasList->addMedia($selectedMedia);
        $mediasListRepository->save($mediasList, true);
        return $this->redirectToRoute('admin_app_mediaslist_index');
    }

    return $this->render('Back/mediasList/addMedia.html.twig', [
        'linkedArtist' => $linkedArtist,
        'mediasList' => $mediasList,
        'form' => $form->createView(),
    ]);
  }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('/medias/{id}/{idMedia} ', name: 'app_mediaslist_remove_media', methods: ['POST'])]
  public function removeMedia(MediasList $mediasList, MediasListRepository $mediasListRepository, MediaRepository $mediaRepository, $idMedia): Response
  {
    $media = $mediaRepository->find($idMedia);
    $mediasList->removeMedia($media);
    $mediasListRepository->save($mediasList, true);

    return $this->redirectToRoute('admin_app_mediaslist_medias', ['id' => $mediasList->getId()], Response::HTTP_SEE_OTHER);
  }
  


  #[IsGranted('ROLE_ARTIST')]
  #[Route('/{id}',  name: 'app_mediaslist_delete', methods: ['POST'])]
  public function delete(Request $request, MediasList $mediasList, MediasListRepository $mediasListRepository): Response
  {

      if ($this->isCsrfTokenValid('delete'.$mediasList->getId(), $request->request->get('_token'))) {
          $mediasListRepository->remove($mediasList, true);
      }

      return $this->redirectToRoute('admin_app_mediaslist_index', [], Response::HTTP_SEE_OTHER);
  }

  #[IsGranted('ROLE_ARTIST')]
  #[Route('/{id}/edit', name: 'app_mediaslist_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, MediasList $mediasList, MediasListRepository $mediasListRepository): Response
  {
    $idArtist = $this->getUser()->getIdArtist();
    $artistArray = $mediasList->getArtists();
    if (!in_array($idArtist, $artistArray->toArray())) {
      return $this->redirectToRoute('admin_app_medias_index', [], Response::HTTP_SEE_OTHER);
    }
    $form = $this->createForm(MediasListBackType::class, $mediasList);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $mediasListRepository->save($mediasList, true);

      return $this->redirectToRoute('admin_app_mediaslist_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/mediasList/edit.html.twig', [
      'mediasList' => $mediasList,
      'form' => $form,
    ]);
  }
}