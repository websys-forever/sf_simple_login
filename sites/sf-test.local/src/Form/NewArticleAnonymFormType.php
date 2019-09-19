<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class NewArticleAnonymFormType extends AbstractType
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //dd($sessionId);

        /*if ($authorName = $user->getExistAuthorName()) {
        } else {

        }*/
        //dd($authorName);

        $builder
            ->add('title');

        if (!$this->session->get('author_name')) {
            $builder->add('author_name', TextType::class, [
                //'class' => User::class,
                //'choice_label' => 'email',
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