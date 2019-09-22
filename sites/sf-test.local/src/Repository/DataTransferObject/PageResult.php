<?php

namespace App\Repository\DataTransferObject;

use Doctrine\ORM\QueryBuilder;

class PageResult
{
    private $elements;
    private $maxPages;
    private $thisPage;

    /**
    * @param array|null $result
    * @param int $maxPages
    * @param int $thisPage
    */
    public function __construct($result, int $maxPages, int $thisPage)
    {
        $this->elements = $result;
        $this->maxPages = $maxPages;
        $this->thisPage = $thisPage;
    }

    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function getMaxPages(): ?int
    {
        return $this->maxPages;
    }

    public function getThisPage(): ?int
    {
        return $this->thisPage;
    }
}