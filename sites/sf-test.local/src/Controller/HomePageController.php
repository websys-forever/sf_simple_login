<?php

namespace App\Controller;

use App\Repository\Article\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function index(
        Request $request,
        ArticleRepository $articleRepository
    )
    {
        $page = (int) ($request->get('page') ?: 1 );
        $limit = (int) ($request->get('limit') ?: 30 );
        $result = $articleRepository->getAllAuthorsArticles($page, $limit);

        return $this->render('home_page/index.html.twig', [
            'thisPage' => $result->getThisPage(),
            'limit' => $limit,
            'maxPages' => $result->getMaxPages(),
            'articles' => $result->getElements(),
            ]
        );
    }
}
