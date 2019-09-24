<?php

namespace App\Service;

use App\Repository\DataTransferObject\PageResult;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginatorService
{
    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @param QueryBuilder $query
     * @param int $thisPage
     * @param int $limit
     * @return PageResult|null
     */
    public function getQueryBuilderPageResult(
        QueryBuilder $query,
        int $thisPage,
        int $limit): ?PageResult
    {
        $paginator = new Paginator($query);
        $maxPages = ceil($paginator->count() / $limit);
        $elements = $paginator->getIterator()->getArrayCopy() ?: NULL;
        $pageResult = new PageResult(
            $elements,
            $maxPages,
            $thisPage
        );

        return $pageResult;
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param NativeQuery $query
     * @param string $sqlBody
     * @param int $thisPage
     * @param int $limit
     * @return PageResult|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNativeSQLPageResult(
        EntityManagerInterface $entityManager,
        NativeQuery $query,
        string $sqlBody,
        int $thisPage,
        int $limit
    ): ?PageResult
    {
        $elements = $query->getArrayResult() ?: NULL;
        $sqlSelect = 'SELECT COUNT(*) AS count ';
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count', 'integer');
        $sql = $sqlSelect . $sqlBody;
        $countQuery = $entityManager->createNativeQuery($sql, $rsm);
        $countResult = $countQuery->getSingleScalarResult();
        $maxPages = ceil($countResult / $limit);
        $pageResult = new PageResult(
            $elements,
            $maxPages,
            $thisPage
        );

        return $pageResult;
    }
}