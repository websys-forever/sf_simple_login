<?php

namespace App\Controller;

use App\Repository\Article\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(
        SessionInterface $session,
        ArticleRepository $articleRepository
    )
    {
        $articles = $articleRepository->findAll();
//dd(compact('articles'));
        return $this->render('home_page/index.html.twig',
            ['articles' => $articles]
            //compact('articles')
        );
    }
}
