<?php

namespace Andean\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrenHorarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('horario')
            ->add('fecha')
            ->add('espacios')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Andean\TrenBundle\Entity\TrenDisponibilidad'
        ));
    }

    public function getName()
    {
        return 'andean_backendbundle_trendisponibilidadtype';
    }
}
