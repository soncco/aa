<?php

namespace Andean\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
  public function queryUsuarios() {
    $em = $this->getEntityManager();
    $dql = "SELECT u FROM BackendBundle:Usuario u";
    $query = $em->createQuery($dql);
    
    return $query;
  }
  
  public function findUsuarios() {
    return $this->queryUsuarios()->getResult();
  }
}