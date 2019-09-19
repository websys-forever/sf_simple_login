<?php

namespace App\Repository\Article;

use App\Entity\Article;
use App\Repository\DataTransferObject\SessionArticleCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getUserArticles($userId, $page, $limit)
    {
        //$articles = $this->findBy(['author' => $userId]);

        //$query = "SELECT * FROM Article AS a JOIN p.comments c";

/*        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM article a
        WHERE a.author_id = :userId
        ORDER BY a.created_at DESC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['userId' => $userId]);
dd($stmt->fetchAll());
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();*/



        $query = $this->createQueryBuilder('a')
            ->andWhere('a.author = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page - 1)) // Offset
            //->getQuery()
        ;

        $paginator = new Paginator($query);
//        $paginator->getQuery()->getResult();
/*

        ;*/

//dd($paginator);

        return $paginator;
    }

    /**
    * @param SessionInterface $session
    */
    public function getAnonymArticles($session, $page, $limit)
    {
        $articles = $session->get('articles');

        return new SessionArticleCollection($articles);
    }
}
