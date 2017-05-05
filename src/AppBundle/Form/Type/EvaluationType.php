<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Evaluation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', null, ['label' => "Pažymys"])
            ->add('comment', null, ['label' => "Komentaras"]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Evaluation::class,
        ));
    }
}
