<?php

namespace App\Repository\User;

use App\Entity\AnonymUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AnonymUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnonymUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnonymUser[]    findAll()
 * @method AnonymUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnonymUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnonymUser::class);
    }
}
