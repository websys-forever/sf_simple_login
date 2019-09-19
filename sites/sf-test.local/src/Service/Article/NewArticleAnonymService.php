<?php

namespace App\Service\Article;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NewArticleAnonymService implements NewArticleServiceInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        SessionInterface $session
    )
    {
        $this->session = $session;
    }

    public function proccessData(
        FormInterface $form
    )
    {
        $article = [];
        /** @var FormInterface $form */
        $article['title'] = $form['title']->getData();
        $article['content'] = $form['content']->getData();
        $article['created_at'] = new \DateTime();
        $article['updated_at'] = new \DateTime();

        if (!$this->session->get('author_name')) {
            $this->session->set('author_name', $form['author_name']->getData());
        }
        $sessionArticles = [];
        if ($existArticles = $this->session->get('articles')) {
            $sessionArticles = $existArticles;
            $sessionArticles[] = $article;
        } else {
            $sessionArticles[] = $article;
        }

        $this->session->set('articles', $sessionArticles);
    }
}