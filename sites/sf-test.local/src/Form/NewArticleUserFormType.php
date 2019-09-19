<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewArticleUserFormType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();

        $builder
            ->add('title');

        if (!$user->getExistAuthorName()) {
            $builder->add('author_name', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 200])
                ],
            ]);
        }

        $builder
            ->add('content')
            ->add('create', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}