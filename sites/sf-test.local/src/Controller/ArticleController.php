<?php

namespace App\Controller;

use App\Form\NewArticleUserFormType;
use App\Form\NewArticleAnonymFormType;
use App\Repository\Article\ArticleRepository;
use App\Repository\Article\SessionArticleRepository;
use App\Repository\User\AnonymUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Article\NewArticleAnonymService;
use App\Service\Article\NewArticleUserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/new-article", name="new_article")
     * @param Request $request
     * @param SessionInterface $session
     * @param AnonymUserRepository $anonymUserRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newArticle(
        Request $request,
        SessionInterface $session,
        AnonymUserRepository $anonymUserRepository,
        EntityManagerInterface $entityManager
    )
    {
        if ($this->isGranted('ROLE_USER')) {
            $formTypeClass = NewArticleUserFormType::class;
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $articleService = new NewArticleUserService($user, $entityManager);
        } else {
            $formTypeClass = NewArticleAnonymFormType::class;
            $articleService = new NewArticleAnonymService(
                $session,
                $anonymUserRepository,
                $entityManager,
                $request,
                new Response()
            );
        }

        $form = $this->createForm($formTypeClass);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $articleService->proccessData($form);
            $this->addFlash('success', 'Your article created!');

            return $this->redirectToRoute('home_page');
        }

        return $this->render('article/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{articleId}", name="show_article")
     * @param string $articleId
     * @param ArticleRepository $articleRepository
     * @param SessionArticleRepository $sessionArticleRepository
     * @param Request $request
     * @throws
     * @return Response
     */
    public function showArticle(string $articleId, ArticleRepository $articleRepository, SessionArticleRepository $sessionArticleRepository, Request $request)
    {
        $article = $articleRepository->findArticle($articleId);
        if (empty($article)) {
            $article = $sessionArticleRepository->findArticle($articleId);
        }

        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }
}
