<?php

namespace App\Controller\Front;

use App\Entity\MediasList;
use App\Entity\Arist;
use App\Form\MediasListType;
use App\Repository\MediasListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;


#[Route('/medias/list')]
class MediasListController extends AbstractController
{
    #[Route('/', name: 'app_medias_list_index', methods: ['GET'])]
    public function index(MediasListRepository $mediasListRepository): Response
    {
        // $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/medias_list/index.html.twig', [
            'medias_lists' => $mediasListRepository->findAll(),
            // 'searchForm' => $searchForm->createView()
        ]);
    }

    #[Route('/new', name: 'app_medias_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MediasListRepository $mediasListRepository): Response
    {
        // $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $mediasList = new MediasList();
        $form = $this->createForm(MediasListType::class, $mediasList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mediasListRepository->save($mediasList, true);

            return $this->redirectToRoute('front_app_medias_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/medias_list/new.html.twig', [
            'medias_list' => $mediasList,
            'form' => $form,
            // 'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_medias_list_show', methods: ['GET'])]
    public function show(MediasList $mediasList, MediasListRepository $mediasListRepository): Response
    {
        // $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/medias_list/show.html.twig', [
            'medias_list' => $mediasList,
            // 'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medias_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MediasList $mediasList, MediasListRepository $mediasListRepository): Response
    {
        // $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $form = $this->createForm(MediasListType::class, $mediasList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mediasListRepository->save($mediasList, true);

            return $this->redirectToRoute('front_app_medias_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/medias_list/edit.html.twig', [
            'medias_list' => $mediasList,
            'form' => $form,
            // 'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_medias_list_delete', methods: ['POST'])]
    public function delete(Request $request, MediasList $mediasList, MediasListRepository $mediasListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mediasList->getId(), $request->request->get('_token'))) {
            $mediasListRepository->remove($mediasList, true);
        }

        return $this->redirectToRoute('front_app_medias_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
