<?php

namespace App\Repository\Article;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\DataTransferObject\PageResult;
use App\Service\PaginatorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ManagerRegistry $registry
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ManagerRegistry $registry,
        Security $security,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Article::class);
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $page
     * @param int $limit
     * @return PageResult|null
     */
    public function getUserArticles(int $page, int $limit): ?PageResult
    {
        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        $userId = $user->getId();

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.author = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page - 1)); // Offset

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
            )->innerJoin(User::class, 'u', 'WITH', 'u.id = a.author')
            ->andWhere('a.id = :articleId')
            ->setParameter('articleId', $articleId);

        $result = $query->getQuery()->getArrayResult();
        return $result ? $result[0] : [] ;
    }

    /**
     * @param int $page
     * @param int $limit
     * @return PageResult|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAllAuthorsArticles(int $page = 1, int $limit = 30): ?PageResult
    {
        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $this->getEntityManager()->getConnection();

        $sqlSelect = 'SELECT
                        a1.id, 
                        a1.title, 
                        a1.content,
                        a1.created_at,
                        a1.author_id,
                        a1.author_name ';

        $sqlBody = '
            FROM              
                  (SELECT 
                    a.id, 
                    a.title, 
                    a.content,
                    a.created_at,
                    a.author_id,
                    u.author_name
                  FROM article AS a
                    JOIN user AS u ON u.id = a.author_id 
                  UNION ALL 
                  SELECT
                    sa.id, 
                    sa.title, 
                    sa.content,
                    sa.created_at,
                    sa.author_id,
                    au.author_name
                  FROM session_article AS sa 
                    JOIN anonym_user AS au ON au.id = sa.author_id
                  ) AS a1
                  ORDER BY a1.created_at DESC
                  ';
        $sqlWithLimit = $sqlSelect . $sqlBody . ' LIMIT :limit OFFSET :offset';
        $offset = $limit * ($page - 1);
        $stmt = $conn->prepare($sqlWithLimit);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $pageResult = $stmt->fetchAll();
        $paginator = new PaginatorService();

        return $paginator->getSQLPageResult(
            $this->entityManager,
            $pageResult,
            $sqlBody,
            $page,
            $limit
        );
    }
}
