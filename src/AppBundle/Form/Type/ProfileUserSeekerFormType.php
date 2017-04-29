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
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProfileUserSeekerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Vardas*'])
            ->add('surname', null, ['label' => 'Pavardė*'])
            ->add('email', EmailType::class, [
                'label' => 'El. paštas*'
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'label' => 'Gimimo data',
                'invalid_message' => 'Neteisingas datos formatas. Įvesk datą tokiu formatu: yyyy-mm-dd.'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('phone', null, [
                'label' => 'Telefonas'
            ])
            ->add('city', null, [
                'constraints' => new NotBlank(),
                'label' => 'Miestas*'
            ])
            ->add('profession', null, [
                'constraints' => new NotBlank(),
                'label' => 'Profesija*'
            ])
            ->add('introduction', TextareaType::class, [
                'constraints' => new NotBlank([
                    'message' => 'Papasakok trumpai apie save- kokie tavo gebėjimai, kokio darbo šiuo metu ieškai.',
                    ]),
                'label' => 'Trumpas prisistatymas*',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserSeeker::class
        ));
    }
}
