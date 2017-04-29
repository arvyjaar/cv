<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserEmployer;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProfileUserEmployerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Įmonės pavadinimas*'])
            ->add('description', null, ['label' => 'Trumpai apie įmonę'])
            ->add('phone', null, ['label' => 'Telefonas'])
            ->add('email', EmailType::class, [
                'label' => 'El. paštas*'
            ])
            ->add('city', null, ['label' => 'Miestas'])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('sector', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Įveskite veiklos sektorių, kuriame specializuojasi jūsų įmonė.'])
                ],
                'label' => 'Sektorius*'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserEmployer::class,
        ));
    }
}
