<?php

namespace App\Service\Article;

use App\Entity\Article;
use App\Entity\User;
use App\Form\NewArticleUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class NewArticleUserService implements NewArticleServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var User
     */
    private $user;

    public function __construct(
        User $user,
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    /**
     * @param NewArticleUserFormType $form
     * @return void
     */
    public function proccessData(FormInterface $form)
    {
        $article = new Article();
        /** @var FormInterface $form */
        $article->setTitle($form['title']->getData());
        $article->setContent($form['content']->getData());
        $article->setAuthor($this->user);

        if (!$this->user->getExistAuthorName()) {
            $this->user->setAuthorName($form['author_name']->getData());
        }

        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }
}