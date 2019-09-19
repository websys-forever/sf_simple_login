<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserAuthorNameFormType extends AbstractType
{
    private $userRepository;
    private $security;

    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        //dd($user->getExistAuthorName());

        $builder
            ->add('title');
        if (!$user->getExistAuthorName()) {
            $builder->add('author_name', UserAuthor::class, [
                //'class' => User::class,
                //'choice_label' => 'email',
                'mapped' => false,
            ]);
        }


        $builder
            ->add('content')
            ->add('save', SubmitType::class)
        ;


    }

    public function getParent()
    {
        return TextType::class;
    }
}