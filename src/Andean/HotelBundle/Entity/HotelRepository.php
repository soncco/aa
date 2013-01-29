<?php

namespace Andean\HotelBundle\Entity;

use Doctrine\ORM\EntityRepository;

class HotelRepository extends EntityRepository
{
  public function findDisponibilidad($habitacion, $fecha) {
    
    $em = $this->getEntityManager();
    
    $dql = "SELECT d
              FROM HotelBundle:HotelDisponibilidad d
              WHERE d.habitacion = :habitacion
              AND d.fecha = :fecha";
    
    $consulta = $em->createQuery($dql);
    $consulta->setParameter('habitacion', $habitacion);
    $consulta->setParameter('fecha', $fecha);
    $consulta->setMaxResults(1);
    
    return $consulta->getOneOrNullResult();
  }
  
  public function updateEspacios($habitacion, $fecha, $espacios) {
    $em = $this->getEntityManager();
    
    $dql = "UPDATE HotelBundle:HotelDisponibilidad d
            SET d.espacios = :espacios
            WHERE d.habitacion = :habitacion
            AND d.fecha = :fecha";
    
    $consulta = $em->createQuery($dql);
    $consulta->setParameter('habitacion', $habitacion);
    $consulta->setParameter('fecha', $fecha);
    $consulta->setParameter('espacios', $espacios);
    
    return $consulta->execute();
  }
}