<?php

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserEmployer;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileUserEmployerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => false])
            ->add('description', null, ['label' => false])
            ->add('phone', null, ['label' => false])
            ->add('city', null, ['label' => false])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('sector', null, [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserEmployer::class,
        ));
    }
}