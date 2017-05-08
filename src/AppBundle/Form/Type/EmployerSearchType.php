<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class EmployerSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', SearchType::class, [
                'label' => false,
                'required' => false,
                'constraints' => new Length(['max' => 30]),
            ])
            ->add('sector', EntityType::class, [
                'label' => false,
                'placeholder' => 'Sektorius',
                'required' => false,
                'class' => 'AppBundle\Entity\Sector',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('se')->orderBy('se.title', 'ASC');
                },
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            // Don't set data_class !
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        // to avoid form values wrapping inside array
        return '';
    }
}
