<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\NewArticleUserFormType;
use App\Form\NewArticleAnonymFormType;
use App\Repository\Article\ArticleRepository;
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
     */
    public function newArticle(
        Request $request,
        //Response $response,
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

        //if ($this->isGranted('ROLE_USER')) {
            //$form = $this->newArticleUser($request, $entityManager);

        $form = $this->createForm($formTypeClass);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $articleService->proccessData($form);

            $this->addFlash('success', 'Your article created!');

            return $this->redirectToRoute('home_page');
        }

        //} else {
            //$form = $this->newArticleAnonym($request, $entityManager, $session);
        //}

        return $this->render('article/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    public function newArticleUser(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(NewArticleUserFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article = new Article();
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $article->setTitle($form['title']->getData());
            $article->setContent($form['content']->getData());
            $article->setAuthor($user);

            if (!$user->getExistAuthorName()) {
                $user->setAuthorName($form['author_name']->getData());
            }

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Your article created!');

            return $this->redirectToRoute('author_articles');
        }

        return $this->render('article/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    public function newArticleAnonym
    (
        Request $request,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    )
    {
        $form = $this->createForm(NewArticleAnonymFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article['title'] = $form['title']->getData();
            $article['content'] = $form['content']->getData();
            $article['created_at'] = new \DateTime();
            $article['updated_at'] = new \DateTime();
            //dd($article);

            if (!$session->get('author_name')) {
                $session->set('author_name', $form['author_name']->getData());
            }
            $sessionArticles = [];
            if ($existArticles = $session->get('articles')) {
                $sessionArticles = $existArticles;
                $sessionArticles[] = $article;
            } else {
                $sessionArticles[] = $article;
            }

            $session->set('articles', $sessionArticles);

            $this->addFlash('success', 'Your article created (in session)!');

            $this->redirectToRoute('author_articles');
        }

        //dd('test2');

        return $form;
    }

    /**
     * @Route("/article/{id}", name="show_article")
     */
    public function showArticle(ArticleRepository $articleRepository, Request $request)
    {
       return new Response($request->get('id'));
    }
}
