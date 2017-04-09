<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserSeeker;

class ProfileUserSeekerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => false])
            ->add('surname', null, ['label' => false])
            ->add('birthday', null, ['label' => false])
            ->add('surname', null, ['label' => false])
            ->add('photo', FileType::class, ['label' => false, 'data_class' => null, 'required' => false, ])
            ->add('phone', null, ['label' => false])
            ->add('city', null, ['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserSeeker::class,
        ));
    }
}
