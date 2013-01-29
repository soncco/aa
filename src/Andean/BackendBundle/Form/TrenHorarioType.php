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
            ->add('partida')
            ->add('llegada')
            ->add('precio_ninos')
            ->add('precio_adultos')
            ->add('tipo', null, array(
                'required' => 'true'
                ))
            ->add('origen', null, array(
                'required' => 'true'
                ))
            ->add('destino', null, array(
                'required' => 'true'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Andean\TrenBundle\Entity\TrenHorario'
        ));
    }

    public function getName()
    {
        return 'andean_backendbundle_trenhorariotype';
    }
}
