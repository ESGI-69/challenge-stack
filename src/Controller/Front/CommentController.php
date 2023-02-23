<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;


#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('Front/comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
            'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentRepository $commentRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
            'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, ['action' => $this->generateUrl('front_app_search'),'method' => 'POST']);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'searchForm' =>  $searchForm->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $referer = $request->headers->get('referer');

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token')) && $comment->getIdUser() === $this->getUser()) {
            $commentRepository->remove($comment, true);
        }

        return $this->redirect($referer);
    }
}
