<?php
/**
 * Created by PhpStorm.
 * User: arvydas
 * Date: 4/5/17
 * Time: 10:00 PM
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use AppBundle\Entity\UserSeeker;

class RegistrationUserSeekerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Vardas*'])
            ->add('surname', null, ['label' => 'Pavardė*'])
            ->add('email', EmailType::class, ['label' => 'El. paštas*'])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Slaptažodis*'],
                'second_options' => ['label' => 'Patvirtink slaptažodį*'],
                'invalid_message' => 'Slaptažodis nesutampa',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserSeeker::class,
            'csrf_token_id' => 'registration'
        ));
    }
}
