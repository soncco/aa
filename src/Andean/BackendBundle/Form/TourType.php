<?php

namespace Andean\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulario para crear y manipular entidades de tipo Tour.
 * Como se utiliza en el backend, el formulario incluye todas las propiedades
 * de la entidad.
 */
class TourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('precio')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Andean\BackendBundle\Entity\Tour',
        ));
    }

    public function getName()
    {
        return 'andean_backendbundle_tourtype';
    }
}
