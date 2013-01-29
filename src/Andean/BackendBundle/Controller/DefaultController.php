<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Andean\BackendBundle\Entity\Usuario;

class DefaultController extends Controller
{
  
    public function indexAction()
    {
      // Usuario logueado.
      $usuario = $this->get('security.context')->getToken()->getUser();
      $nombres = $usuario->getNombres();
        
      return $this->render('BackendBundle:Default:index.html.twig');
    }
    
    public function loginAction() {
      
      $peticion = $this->getRequest();
      
      $sesion = $peticion->getSession();
      
      $error = $peticion->attributes->get(
        SecurityContext::AUTHENTICATION_ERROR,
        $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
      );
      
      if($error) {
        $this->get('session')->setFlash('error',
          'No existe el usuario o la contraseña es incorrecta'
        );
      }
      
      return $this->render('BackendBundle:Default:login.html.twig', array(
        'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
        'error' => $error
      ));
    }
}
