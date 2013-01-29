<?php

namespace Andean\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Andean\BackendBundle\Entity\Usuario;

class Usuarios implements FixtureInterface, ContainerAwareInterface
{
  private $container;
  
  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }
  
  public function load(ObjectManager $manager)
  {
    for ($i=1; $i<=20; $i++) {
      
      $passwordEnClaro = 'usuario' . $i;
      
      $usuario = new Usuario();
      
      $usuario->setNombres('Usuario ' . $i);
      $usuario->setUsuario('usuario'. $i);
      $usuario->setEmail('email' . $i . '@email.com');
      $usuario->setSalt(md5(time()));
      $usuario->setRol('A');
      
      $salt = md5(time());
      
      $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
      
      $password = $encoder->encodePassword($passwordEnClaro, $salt);
      
      $usuario->setPassword($password);
      $usuario->setSalt($salt);
      
      $manager->persist($usuario);
    }
    
    $manager->flush();    
  }
}