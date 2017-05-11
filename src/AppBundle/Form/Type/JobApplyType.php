<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\JobApply;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class JobApplyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assignmentSolution', UrlType::class, [
                'default_protocol' => '',
                'label' => 'Nuoroda į užduoties sprendimą*'
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobApply::class
        ]);
    }
}
