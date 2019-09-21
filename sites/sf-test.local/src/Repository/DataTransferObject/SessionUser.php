<?php

namespace App\Repository\DataTransferObject;

class SessionUser
{
    private $title;
    private $content;
    private $author_name;
    private $created_at;

    public function __construct(array $article)
    {
        $this->title = $article['title'];
        $this->content = $article['content'];
        $this->author = $article['content'];
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