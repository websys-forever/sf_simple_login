<?php

namespace App\Service\Article;

use App\Entity\AnonymUser;
use App\Entity\SessionArticle;
use App\Repository\User\AnonymUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NewArticleAnonymService implements NewArticleServiceInterface
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var AnonymUserRepository
     */
    private $anonymUserRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;

    /**
     * @param SessionInterface $session
     * @param AnonymUserRepository $anonymUserRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function __construct(
        SessionInterface $session,
        AnonymUserRepository $anonymUserRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        Response $response
    )
    {
        $this->session = $session;
        $this->anonymUserRepository = $anonymUserRepository;
        $this->entityManager = $entityManager;
        $this->request = $request;
        $this->response = $response;
    }

    public function proccessData(
        FormInterface $form
    )
    {
        $article = new SessionArticle();
        /** @var FormInterface $form */
        $article->setTitle($form['title']->getData());
        $article->setContent($form['content']->getData());

        $sessionId = $this->session->getId();
        //dd($sessionId);
        /** @var AnonymUser $anonymUser */
        $anonymUser = $this->anonymUserRepository->findOneBy(['session_id' => $sessionId]);
        if (empty($anonymUser)) {
            $anonymUser = new AnonymUser();
            $anonymUser->setSessionId($sessionId);
        }
        $article->setAuthor($anonymUser);
        if (!$anonymUser->getExistAuthorName()) {
            $anonymUser->setAuthorName($form['author_name']->getData());
        }

        $this->entityManager->persist($anonymUser);
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        if (empty($this->request->cookies->get('user'))) {
            $this->response->headers->setCookie(Cookie::create('user', $anonymUser->getId()));
            $this->response->sendHeaders();
        }

    }
}