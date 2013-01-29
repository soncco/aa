<?php

namespace Andean\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Andean\TrenBundle\Util\Util;

/**
 * @ORM\Entity(repositoryClass="Andean\HotelBundle\Entity\HotelRepository")
 * @ORM\Table(name="hotel_habitacion")
 */
class HotelHabitacion
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Andean\HotelBundle\Entity\HotelEmpresa")
     */
    protected $hotel;

    /**
     * @ORM\ManyToOne(targetEntity="\Andean\HotelBundle\Entity\Acomodacion")
     */
    protected $acomodacion;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $precio;

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
    * Set hotel
    *
    * @param string $nombre
    */
    public function setHotel(\Andean\HotelBundle\Entity\HotelEmpresa $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
    * Get hotel
    *
    * @return Andean\HotelBundle\Entity\HotelEmpresa
    */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * set Categoria
     * @param Andean\HotelBundle\Entity\Categoria $categoria 
     */
    public function setAcomodacion(\Andean\HotelBundle\Entity\Acomodacion $acomodacion)
    {
        $this->acomodacion = $acomodacion;
    }

    /**
     * get Categoria
     * @return Andean\HotelBundle\Entity\Categoria 
     */
    public function getAcomodacion()
    {
        return $this->acomodacion;
    }
    
    /**
     * set Precio
     * @param decimal $precio 
     */
    public function setPrecio($precio) {
      $this->precio = $precio;
    }
    
    /**
     * get Precio
     * @return decimal
     */
    public function getPrecio() {
      return $this->precio;
    }
}