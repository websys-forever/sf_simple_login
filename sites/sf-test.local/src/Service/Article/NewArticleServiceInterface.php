<?php

namespace App\Service\Article;

use Symfony\Component\Form\FormInterface;

interface NewArticleServiceInterface
{
    public function proccessData(FormInterface $form);
}