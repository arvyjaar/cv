<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class JobAdType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Siūloma pozicija*'])
            ->add('description', null, ['label' => 'Apie siūlomą poziciją:*'])
            ->add('assignment', null, ['label' => 'Užduotis kandidatams (url)'])
            ->add('requirements', HiddenType::class, array(
                'data' => '',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\JobAd'
        ));
    }

    /**
     * {@inheritdoc}
     */
    /*    public function getBlockPrefix()
        {
            return 'appbundle_jobad';
        }*/
}
