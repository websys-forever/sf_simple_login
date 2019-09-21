<?php

namespace App\Repository\Article;

use App\Entity\SessionArticle;
use App\Repository\User\AnonymUserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method SessionArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionArticle[]    findAll()
 * @method SessionArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionArticleRepository extends ServiceEntityRepository
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var AnonymUserRepository
     */
    private $anonymUserRepository;

    public function __construct(
        ManagerRegistry $registry,
        SessionInterface $session,
        AnonymUserRepository $anonymUserRepository
    )
    {
        parent::__construct($registry, SessionArticle::class);
        $this->session = $session;
        $this->anonymUserRepository = $anonymUserRepository;
    }

    public function getAnonymArticles($page, $limit)
    {
        $sessionId = $this->session->getId();
        $user = $this->anonymUserRepository->findOneBy(['session_id' => $sessionId]);

        $userId = NULL;
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.author = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page - 1)) // Offset
        ;

        $paginator = new Paginator($query);

        return $paginator;
    }
}
