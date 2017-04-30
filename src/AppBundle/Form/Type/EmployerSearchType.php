<?php
/**
 * Created by arvydas.
 * Date: 4/29/17 - Time: 8:15 PM
 */

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('title', SearchType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('sector', EntityType::class, [
                'label' => false,
                'placeholder' => 'Sektorius',
                'required' => false,
                'class' => 'AppBundle\Entity\Sector',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('se')->orderBy('se.title', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // Don't set data_class !
        ));
    }
}
