<?php

namespace Andean\TrenBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TrenRepository extends EntityRepository
{
  
  public function findDisponibilidad($horario, $fecha) {
    
    $em = $this->getEntityManager();
    
    $dql = "SELECT d
              FROM TrenBundle:TrenDisponibilidad d
              WHERE d.horario = :horario
              AND d.fecha = :fecha";
    
    $consulta = $em->createQuery($dql);
    $consulta->setParameter('horario', $horario);
    $consulta->setParameter('fecha', $fecha);
    $consulta->setMaxResults(1);
    
    return $consulta->getOneOrNullResult();
  }
  
  public function updateEspacios($horario, $fecha, $espacios) {
    $em = $this->getEntityManager();
    
    $dql = "UPDATE TrenBundle:TrenDisponibilidad d
            SET d.espacios = :espacios
            WHERE d.horario = :horario
            AND d.fecha = :fecha";
    
    $consulta = $em->createQuery($dql);
    $consulta->setParameter('horario', $horario);
    $consulta->setParameter('fecha', $fecha);
    $consulta->setParameter('espacios', $espacios);
    
    return $consulta->execute();
  }
}