<?php

namespace App\Repository\Article;

use App\Entity\AnonymUser;
use App\Entity\Article;
use App\Entity\SessionArticle;
use App\Entity\User;
use App\Repository\DataTransferObject\PageResult;
use App\Service\PaginatorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
     * @return PageResult|null
     */
    public function getUserArticles(int $page, int $limit)
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

    public function getAllAuthorsArticles($page = 1, $limit = 2)
    {
        $rsm = new ResultSetMapping();
        //$rsm = new ResultSetMappingBuilder($this->entityManager);
        //$rsm->addRootEntityFromClassMetadata(Article::class, 'a');
        $rsm->addEntityResult(Article::class, 'a');
            $rsm->addFieldResult('a', 'id', 'id');
            $rsm->addFieldResult('a', 'title', 'title');
            $rsm->addFieldResult('a', 'content', 'content');
            $rsm->addFieldResult('a', 'created_at', 'created_at');
        $rsm->addJoinedEntityResult(User::class, 'u', 'a', 'author');
        //$rsm->addFieldResult('a', 'author_id', 'author');
            $rsm->addFieldResult('u', 'author_id', 'id');
            $rsm->addFieldResult('u', 'author_name', 'author_name');
        $rsm->addEntityResult(SessionArticle::class, 'sa');
            $rsm->addFieldResult('sa', 'id', 'id');
            $rsm->addFieldResult('sa', 'title', 'title');
            $rsm->addFieldResult('sa', 'content', 'content');
            $rsm->addFieldResult('sa', 'created_at', 'created_at');
        $rsm->addJoinedEntityResult(AnonymUser::class, 'au', 'sa', 'author');
            $rsm->addFieldResult('au', 'author_id', 'id');
            $rsm->addFieldResult('au', 'author_name', 'author_name');
        //$rsm->addFieldResult('s', 'author_id', 'author');

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
                  ) AS a1';

        $sqlWithLimit = $sqlSelect . $sqlBody . ' LIMIT :limit OFFSET :offset';
        $query = $this->entityManager->createNativeQuery($sqlWithLimit, $rsm);
        //dd($query);
        $offset = $limit * ($page - 1);
        $query->setParameter('limit', $limit);
        $query->setParameter('offset', $offset);

        //$articles = $query;//->getResult();

        //dd($articles);
        //$query = $query->getQuery();

        $paginator = new PaginatorService();

        return $paginator->getNativeSQLPageResult(
            $this->entityManager,
            $query,
            $sqlBody,
            $page,
            $limit
        );
    }
}
