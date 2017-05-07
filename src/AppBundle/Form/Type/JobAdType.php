<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\JobAd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
            ->add('description', null, [
//                'class' => 'tinymce',
                'label' => 'Apie siūlomą poziciją:*'
            ])
            ->add('assignment', UrlType::class, [
                'default_protocol' => '',
                'label' => 'Užduotis kandidatams*'
            ])
            ->add('requirements', HiddenType::class, array(
                'data' => '',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobAd::class
        ]);
    }
}
