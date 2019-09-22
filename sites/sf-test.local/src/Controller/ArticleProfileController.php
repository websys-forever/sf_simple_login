<?php

namespace App\Controller;

use App\Form\EditArticleUserFormType;
use App\Repository\Article\ArticleRepository;
use App\Repository\Article\SessionArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleProfileController extends AbstractController
{
    /**
     * @Route("/my", name="author_articles")
     */
    public function authorArticles(
        Request $request,
        ArticleRepository $articleRepository,
        SessionArticleRepository $sessionArticleRepository
    )
    {
        $page = $request->get('page') ?: 1 ;
        $limit = $request->get('limit') ?: 2 ;

        if ($this->isGranted('ROLE_USER')) {
            $result = $articleRepository->getUserArticles($page, $limit);
        } else {
            $result = $sessionArticleRepository->getAnonymArticles($page, $limit);
        }

        return $this->render('author_articles/index.html.twig', [
            'thisPage' => $result->getThisPage(),
            'limit' => $limit,
            'maxPages' => $result->getMaxPages(),
            'articles' => $result->getElements(),
        ]);
    }

    /**
     * @Route("/my/article/remove/{id}", name="remove_article")
     */
    public function removeArticle(
        Request $request,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager
    )
    {
        if (!$this->isGranted('ROLE_USER')) {

            $this->addFlash('error', 'Register or login for manage your articles.');

            return $this->redirectToRoute('app_register');
        }

        $article = $articleRepository->findOneBy(['id' => $request->get('id')]);
        $userId = $this->getUser()->getId();

        if ($article->getAuthor()->getId() !== $userId) {
            $this->addFlash('error', 'Access denied');

            return $this->redirectToRoute('app_register');
        }

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'Article removed');

        return $this->redirectToRoute('author_articles');
    }

    /**
     * @Route("/my/article/edit/{id}", name="edit_article")
     */
    public function editArticle(
        Request $request,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager
    )
    {
        if (!$this->isGranted('ROLE_USER')) {

            $this->addFlash('error', 'Register or login for manage your articles.');

            return $this->redirectToRoute('app_register');
        }

        $article = $articleRepository->findOneBy(['id' => $request->get('id')]);
        $userId = $this->getUser()->getId();

        if ($article->getAuthor()->getId() !== $userId) {
            $this->addFlash('error', 'Access denied');

            return $this->redirectToRoute('app_register');
        }

        $form = $this->createForm(EditArticleUserFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setTitle($form['title']->getData());
            $article->setContent($form['content']->getData());
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Your amazing article edited!');

            return $this->redirectToRoute('author_articles');
        }

        return $this->render('author_articles/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }
}
