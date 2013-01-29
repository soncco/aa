<?php

namespace Andean\TrenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Andean\TrenBundle\Util\Util;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @ORM\Entity(repositoryClass="Andean\TrenBundle\Entity\TrenRepository")
 * @ORM\Table(name="tren_horario")
 * @Assert\Callback(methods={"sonCiudadesDiferentes", "esPrecioValido"})
 */
class TrenHorario
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Andean\TrenBundle\Entity\TrenTipo")
     */
    protected $tipo;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Time()
     */
    protected $partida;
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Time()
     */
    protected $llegada;
    
    /**
     * @ORM\ManyToOne(targetEntity="Andean\TrenBundle\Entity\Ciudad")
     */
    protected $origen;
    
    /**
     * @ORM\ManyToOne(targetEntity="Andean\TrenBundle\Entity\Ciudad")
     */
    protected $destino;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $precio_adultos;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $precio_ninos;
    
    public function __construct() {
    }

    public function __toString()
    {
        return (string)$this->getId();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * set partida
     * @param time $partida 
     */
    public function setPartida($partida) {
      $this->partida = $partida;
    }
    
    /**
     * get partida
     * @return time
     */
    public function getPartida() {
      return $this->partida;
    }
    
    /**
     * set llegada
     * @param time $llegada 
     */
    public function setLlegada($llegada) {
      $this->llegada = $llegada;
    }
    
    /**
     * get llegada
     * @return time
     */
    public function getLlegada() {
      return $this->llegada;
    }

    /**
     * set Tipo
     * @param \Andean\TrenBundle\Entity\TrenTipo $tipo
     */
    public function setTipo(\Andean\TrenBundle\Entity\TrenTipo $tipo) {
      $this->tipo = $tipo;
    }
    
    /**
     * Get Tipo
     * @return \Andean\TrenBundle\Entity\TrenTipo
     */
    public function getTipo() {
      return $this->tipo;
    }
    
    /**
     * set Origen
     * @param \Andean\TrenBundle\Entity\Ciudad $origen
     */
    public function setOrigen(\Andean\TrenBundle\Entity\Ciudad $origen) {
      $this->origen = $origen;
    }
    
    /**
     * Get Origen
     * @return \Andean\TrenBundle\Entity\Ciudad
     */
    public function getOrigen() {
      return $this->origen;
    }
    
    /**
     * set Destino
     * @param \Andean\TrenBundle\Entity\Ciudad $destino
     */
    public function setDestino(\Andean\TrenBundle\Entity\Ciudad $destino) {
      $this->destino = $destino;
    }
    
    /**
     * Get Destino
     * @return \Andean\TrenBundle\Entity\Ciudad
     */
    public function getDestino() {
      return $this->destino;
    }
    
    /**
     * set Precio
     * @param decimal $precio_ninos
     */
    public function setPrecioNinos($precio_ninos) {
      $this->precio_ninos = $precio_ninos;
    }
    
    /**
     * get Precio
     * @return decimal
     */
    public function getPrecioNinos() {
      return $this->precio_ninos;
    }
    
    /**
     * set Precio
     * @param decimal $precio_adultos
     */
    public function setPrecioAdultos($precio_adultos) {
      $this->precio_adultos = $precio_adultos;
    }
    
    /**
     * get Precio
     * @return decimal
     */
    public function getPrecioAdultos() {
      return $this->precio_adultos;
    }
    
    public function sonCiudadesDiferentes(ExecutionContext $context) {
      $origen = $this->getOrigen();
      $destino = $this->getDestino();
      
      if($origen == $destino) {
        $context->addViolationAtSubPath('destino', 'El origen y el destino no pueden ser los mismos.', array(), null);
      }
    }
    
    public function esPrecioValido(ExecutionContext $context) {
      if(!is_numeric($this->precio_ninos)) {
        $context->addViolationAtSubPath('precio_ninos', 'El precio no es válido.', array(), null);
      }
      
      if(!is_numeric($this->precio_adultos)) {
        $context->addViolationAtSubPath('precio_adultos', 'El precio no es válido.', array(), null);
      }
    }

}