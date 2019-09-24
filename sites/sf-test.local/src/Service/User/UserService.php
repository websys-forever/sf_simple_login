<?php

namespace App\Service\User;

use App\Entity\AnonymUser;
use App\Entity\Article;
use App\Entity\SessionArticle;
use App\Entity\User;
use App\Repository\Article\SessionArticleRepository;
use App\Repository\User\AnonymUserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    /**
     * @var AnonymUserRepository
     */
    private $anonymUserRepository;
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
    /**
     * @var Response
     */
    private $response;

    /**
     * @param RequestStack $requestStack
     * @param AnonymUserRepository $anonymUserRepository
     * @param SessionArticleRepository $sessionArticleRepository
     * @return void
     */
    public function __construct(
        RequestStack $requestStack,
        AnonymUserRepository $anonymUserRepository,
        SessionArticleRepository $sessionArticleRepository
    )
    {
        $this->anonymUserRepository = $anonymUserRepository;
        $this->sessionArticleRepository = $sessionArticleRepository;
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getCurrentRequest();
        $this->response = new REsponse();
    }

    /**
     * @return AnonymUser
     */
    public function getAnonymUser(): ?AnonymUser
    {
        $anonymUserId = $this->request->cookies->get('user');
        $anonymUser = $this->anonymUserRepository->findOneBy(['id' => $anonymUserId]);

        return $anonymUser;
    }


    /**
     * @return SessionArticle[]
     */
    public function getExistSessionArticles(): ?array
    {
        $anonymUser = $this->getAnonymUser();
        $sessionArticles = $this->sessionArticleRepository->findBy(['author' => $anonymUser]);

        return $sessionArticles;
    }

    /**
     * @param User $user
     * @param ObjectManager $entityManager
     * @return void
     */
    public function bindAndPersistExistArticles(User $user, ObjectManager $entityManager)
    {
        $existSessionArticles = $this->getExistSessionArticles();

        if (!empty($existSessionArticles)) {
            /** @var SessionArticle $existArticle*/
            foreach ($existSessionArticles as $existArticle) {
                $bindArticle = new Article();
                $bindArticle->setTitle($existArticle->getTitle());
                $bindArticle->setContent($existArticle->getContent());
                $bindArticle->setAuthor($user);
                $entityManager->persist($bindArticle);
            }
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function bindExistUserData(User $user)
    {
        $anonymUser = $this->getAnonymUser();
        $existAuthorName = $anonymUser->getExistAuthorName();
        if ($existAuthorName) {
            $user->setAuthorName($existAuthorName);
        }
    }

    /**
     * @return void
     */
    public function removeAnonymUserCookie()
    {
        $this->response->headers->clearCookie('user');
        $this->response->sendHeaders();
    }

}