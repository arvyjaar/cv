<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserEmployer;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Doctrine\ORM\EntityRepository;

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
            ->add('sector', EntityType::class, [
                'class' => 'AppBundle\Entity\Sector',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('cat')->orderBy('cat.title', 'ASC');
                },
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
