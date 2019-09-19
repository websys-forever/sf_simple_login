<?php

namespace App\Repository\DataTransferObject;

class SessionArticleCollection
{
    private $articles;

    public function __construct(array $articles)
    {
        $this->articles = $articles;
    }

    public function count()
    {
        return count($this->articles);
    }

    public function maxPages(int $limit)
    {
        return ceil($this->count() / $limit);
    }

    public function currentPageArticles(int $page, int $limit)
    {
        $pageArticles = array_chunk($this->articles, $limit);
        array_unshift($pageArticles, 0);
        unset($pageArticles[0]);

        return $pageArticles[$page];
    }

}