<?php

namespace Andean\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @ORM\Entity(repositoryClass="Andean\HotelBundle\Entity\HotelRepository")
 * @ORM\Table(name="hotel_disponibilidad")
 */
class HotelDisponibilidad
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Andean\HotelBundle\Entity\HotelHabitacion")
     */
    protected $habitacion;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100)
     * @Assert\Date()
     */
    protected $fecha;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $espacios;
    
    public function __construct() {
      $this->fecha = date('Y-m-d');
    }
    
    public function __toString() {
      return (string)$this->getEspacios();
    }
    
    /**
     * set Habitacion
     * @param \Andean\HotelBundle\Entity\HotelHabitacion $habitacion
     */
    public function setHabitacion(\Andean\HotelBundle\Entity\HotelHabitacion $habitacion) {
      $this->habitacion = $habitacion;
    }
    
    /**
     * get Horario
     * @return \Andean\HotelBundle\Entity\HotelHabitacion 
     */
    public function getHabitacion() {
      return $this->habitacion;
    }
    
    /**
     * set Fecha
     * @param datetime $fecha 
     */
    public function setFecha($fecha) {
      $this->fecha = $fecha;
    }
    
    /**
     * get Fecha
     * @return datetime
     */
    public function getFecha() {
      return $this->fecha;
    }
    
    /**
     * set Espacios
     * @param integer $espacios 
     */
    public function setEspacios($espacios) {
      $this->espacios = $espacios;
    }
    
    /**
     * get Espacios
     * @return integer 
     */
    public function getEspacios() {
      return $this->espacios;
    }
}