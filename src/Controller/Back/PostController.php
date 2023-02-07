<?php

namespace App\Controller\Back;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/post')]
class PostController extends AbstractController
{   
    #[IsGranted('ROLE_ARTIST')]
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts = null;
        $artistId = $this->getUser()->getIdArtist();
        if ($artistId !== null) {
          $artistId = $artistId->getId();
          $posts = $postRepository->getPostsFromArtist($artistId);
        }
        return $this->render('Back/post/index.html.twig', [
            'posts' => $posts,
            'validation' => false,
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/validation', name: 'app_post_validation', methods: ['GET'])]
    public function validation(PostRepository $postRepository): Response
    {
      $unvalidatedPosts = null;
      $artistId = $this->getUser()->getIdArtist();
      if ($artistId === null) {
        $unvalidatedPosts = null;
      } else {
        $artistId = $artistId->getId();
        $unvalidatedPostIds = $postRepository->getUnvalidatedPostIdsFromArtist($artistId);
        foreach ($unvalidatedPostIds as $unvalidatedPostId) {
          $unvalidatedPosts[] = $postRepository->find($unvalidatedPostId);
        }
      }
    
        return $this->render('Back/post/validation.html.twig', [
            'posts' => $postRepository->findAll(),
            'unvalidatedPosts' => $unvalidatedPosts,
            'validation' => true,
            'artistId' => $artistId,
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}/validate', name: 'app_post_validate', methods: ['GET'])]
    public function validate(Post $post, PostRepository $postRepository): Response
    {
      $post->setValidatedAt(new \DateTimeImmutable());
      $postRepository->save($post, true);
      return $this->redirectToRoute('admin_app_post_validation', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {   
        $linkedArtist = true;
        $idArtist = $this->getUser()->getIdArtist();
        if ($idArtist === null) {
          $linkedArtist = false;
        }
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreatedAt(new \DateTimeImmutable());
            $post->setUpdatedAt(new \DateTimeImmutable());
            $post->setIdUser($this->getUser());
            $post->setIdArtist($idArtist);
            $postRepository->save($post, true);
            return $this->redirectToRoute('admin_app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
            'linkedArtist' => $linkedArtist,
        ]);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('Back/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    { 
        $idArtist = $this->getUser()->getIdArtist();
        if ($idArtist !== $post->getIdArtist()) {
          return $this->redirectToRoute('admin_app_post_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUpdatedAt(new \DateTimeImmutable());
            $postRepository->save($post, true);

            return $this->redirectToRoute('admin_app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ARTIST')]
    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('admin_app_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}/del-validation', name: 'app_post_delete_validation', methods: ['POST'])]
    public function deleteValidation(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('admin_app_post_validation', [], Response::HTTP_SEE_OTHER);
    }
}
