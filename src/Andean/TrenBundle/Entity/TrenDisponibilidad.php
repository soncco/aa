<?php

namespace Andean\TrenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @ORM\Entity(repositoryClass="Andean\TrenBundle\Entity\TrenRepository")
 * @ORM\Table(name="tren_disponibilidad")
 */
class TrenDisponibilidad
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Andean\TrenBundle\Entity\TrenHorario")
     */
    protected $horario;
    
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
     * set Horario
     * @param \Andean\TrenBundle\Entity\TrenHorario $horario
     */
    public function setHorario(\Andean\TrenBundle\Entity\TrenHorario $horario) {
      $this->horario = $horario;
    }
    
    /**
     * get Horario
     * @return \Andean\TrenBundle\Entity\TrenHorario 
     */
    public function getHorario() {
      return $this->horario;
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