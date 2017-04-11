<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserSeeker;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileUserSeekerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => false])
            ->add('surname', null, ['label' => false])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => false
            ])
            ->add('surname', null, ['label' => false])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('phone', null, ['label' => false])
            ->add('city', null, ['label' => false])
            ->add('profession', null, [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => false
            ])
            ->add('introduction', TextareaType::class, ['label' => false, 'required' => false])
            ->add('skills', TextareaType::class, ['label' => false, 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserSeeker::class,
            'attr' => array('novalidate' => 'novalidate')
        ));
    }
}
