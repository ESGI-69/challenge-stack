<?php

namespace App\Controller\Front;

use App\Entity\MediasList;
use App\Form\MediasListType;
use App\Repository\MediasListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medias/list')]
class MediasListController extends AbstractController
{
    #[Route('/', name: 'app_medias_list_index', methods: ['GET'])]
    public function index(MediasListRepository $mediasListRepository): Response
    {
        return $this->render('Front/medias_list/index.html.twig', [
            'medias_lists' => $mediasListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medias_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MediasListRepository $mediasListRepository): Response
    {
        $mediasList = new MediasList();
        $form = $this->createForm(MediasListType::class, $mediasList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediasListRepository->save($mediasList, true);

            return $this->redirectToRoute('app_medias_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/medias_list/new.html.twig', [
            'medias_list' => $mediasList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_list_show', methods: ['GET'])]
    public function show(MediasList $mediasList): Response
    {
        return $this->render('Front/medias_list/show.html.twig', [
            'medias_list' => $mediasList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medias_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MediasList $mediasList, MediasListRepository $mediasListRepository): Response
    {
        $form = $this->createForm(MediasListType::class, $mediasList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediasListRepository->save($mediasList, true);

            return $this->redirectToRoute('app_medias_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medias_list/edit.html.twig', [
            'medias_list' => $mediasList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_list_delete', methods: ['POST'])]
    public function delete(Request $request, MediasList $mediasList, MediasListRepository $mediasListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mediasList->getId(), $request->request->get('_token'))) {
            $mediasListRepository->remove($mediasList, true);
        }

        return $this->redirectToRoute('app_medias_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
