<?php

namespace App\Service\User;

use App\Repository\Article\SessionArticleRepository;
use App\Repository\User\AnonymUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserService
{
    /**
     * @var AnonymUserRepository
     */
    private $anonymUserRepository;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var SessionArticleRepository
     */
    private $sessionArticleRepository;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        RequestStack $requestStack,
        AnonymUserRepository $anonymUserRepository,
        SessionInterface $session,
        SessionArticleRepository $sessionArticleRepository
    )
    {

        $this->anonymUserRepository = $anonymUserRepository;
        $this->session = $session;
        $this->sessionArticleRepository = $sessionArticleRepository;
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getCurrentRequest();

    }

    /**
     * @return string
     */
    public function getAnonymUserId()
    {
        $sessId = $this->session->getId();
        $anonymUserId = $this->anonymUserRepository->findOneBy(['session_id' => $sessId]);

        return $anonymUserId->getId();
    }

    /**
     */
    public function getAnonymUser()
    {
        $anonymUserId = $this->request->cookies->get('user');
        $anonymUser = $this->anonymUserRepository->findOneBy(['id' => $anonymUserId]);

        return $anonymUser;
    }

    public function getExistSessionArticles()
    {
        $anonymUser = $this->getAnonymUser();
        $sessionArticles = $this->sessionArticleRepository->findBy(['author' => $anonymUser]);

        return $sessionArticles;
    }

}