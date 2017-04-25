<?php
/**
 * Created by PhpStorm.
 * User: arvydas
 * Date: 4/5/17
 * Time: 9:59 PM
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use AppBundle\Entity\UserEmployer;

class RegistrationUserEmployerFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Įmonė*'])
            ->add('email', EmailType::class, ['label' => 'El. Paštas*'])
            //->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Slaptažodis*'],
                'second_options' => ['label' => 'Patvirtink slaptažodį*'],
                'invalid_message' => 'Slaptažodis nesutampa',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserEmployer::class,
            'csrf_token_id' => 'registration',
        ));
    }
}
