<?php

namespace App\Form;

use App\Entity\AnonymUser;
use App\Entity\Article;
use App\Repository\User\AnonymUserRepository;
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

    /**
     * @var AnonymUserRepository
     */
    private $anonymUserRepository;

    public function __construct(
        SessionInterface $session,
        AnonymUserRepository $anonymUserRepository
    )
    {
        $this->session = $session;
        $this->anonymUserRepository = $anonymUserRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sessionId = $this->session->getId();
        /** @var AnonymUser $anonymUser */
        $anonymUser = $this->anonymUserRepository->findOneBy(['session_id' => $sessionId]);

        $builder
            ->add('title');

        if (empty($anonymUser) || !$anonymUser->getExistAuthorName()) {
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