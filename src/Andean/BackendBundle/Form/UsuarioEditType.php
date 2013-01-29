<?php
namespace Andean\BackendBundle\Form;

use Andean\BackendBundle\Form\UsuarioType;

/**
 * Formulario para editar el perfil de los usuarios registrados.
 */
class UsuarioEditType extends UsuarioType
{

    public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => array('default')
        );
    }
}
