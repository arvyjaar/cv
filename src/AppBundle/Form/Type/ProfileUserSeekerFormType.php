<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserSeeker;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProfileUserSeekerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Vardas'])
            ->add('surname', null, ['label' => 'Pavardė'])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Gimimo data'
            ])

            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('phone', null, ['label' => 'Telefonas'])
            ->add('city', null, ['label' => 'Miestas'])
            ->add('profession', null, [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => 'Profesija'
            ])
            ->add('introduction', TextareaType::class, ['label' => 'Trumpas prisistatymas', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserSeeker::class
        ));
    }
}
