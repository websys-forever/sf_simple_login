<?php

namespace App\Repository\Article;

use App\Entity\AnonymUser;
use App\Entity\SessionArticle;
use App\Repository\DataTransferObject\PageResult;
use App\Repository\User\AnonymUserRepository;
use App\Service\PaginatorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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

    /**
     * @param ManagerRegistry $registry
     * @param SessionInterface $session
     * @param AnonymUserRepository $anonymUserRepository
     */
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

    /**
     * @param int $page
     * @param int $limit
     * @return PageResult|null
     */
    public function getAnonymArticles(int $page, int $limit): ?PageResult
    {
        $sessionId = $this->session->getId();
        $user = $this->anonymUserRepository->findOneBy(['session_id' => $sessionId]);

        $userId = NULL;
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $query = $this->createQueryBuilder('sa')
            ->andWhere('sa.author = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('sa.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page - 1)) // Offset
        ;

        $paginator = new PaginatorService();

        return $paginator->getQueryBuilderPageResult($query, $page, $limit);
    }

    /**
     * @param string $articleId
     * @return array|null
     */
    public function findArticle(string $articleId): ?array
    {
        $query = $this->createQueryBuilder('a')
            ->select('
            a.id, 
            a.title, 
            a.content, 
            a.created_at, 
            u.id AS author_id,
            u.author_name'
            )->innerJoin(AnonymUser::class, 'u', 'WITH', 'u.id = a.author')
            ->andWhere('a.id = :articleId')
            ->setParameter('articleId', $articleId);

        $result = $query->getQuery()->getArrayResult();
        return $result ? $result[0] : [] ;
    }
}
