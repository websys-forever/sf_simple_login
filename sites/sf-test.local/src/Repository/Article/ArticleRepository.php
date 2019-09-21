<?php

namespace App\Repository\Article;

use App\Entity\Article;
use App\Entity\SessionArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NativeQuery;
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

    public function __construct(
        ManagerRegistry $registry,
        Security $security
    )
    {
        parent::__construct($registry, Article::class);
        $this->security = $security;
    }

    public function getUserArticles($page, $limit)
    {
        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        $userId = $user->getId();

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

    public function getAllAuthorsArticles($page, $limit)
    {
/*        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Article::class, 'a');
        $rsm->addFieldResult('a', 'id', 'id');
        $rsm->addFieldResult('a', 'title', 'title');
        $rsm->addFieldResult('a', 'content', 'content');
        $rsm->addFieldResult('a', 'author_id', 'author');
        $rsm->addFieldResult('a', 'created_at', 'created_at');
        $rsm->addEntityResult(SessionArticle::class, 's');
        $rsm->addFieldResult('s', 'id', 'id');
        $rsm->addFieldResult('s', 'title', 'title');
        $rsm->addFieldResult('s', 'content', 'content');
        $rsm->addFieldResult('s', 'author', 'author_id');
        $rsm->addFieldResult('s', 'created_at', 'created_at');*/

        $query = $this->_em->createNativeQuery('
          SELECT 
            id, 
            title, 
            content,
            author_id
          FROM article
          UNION ALL 
          SELECT
            id, 
            title, 
            content,
            author_id 
          FROM session_article
    
        ', $rsm);

        $articles = $query->getArrayResult();

        dd($articles);

        /** @var \App\Entity\User $user */
        //$user = $this->security->getUser();
        //$userId = $user->getId();

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
