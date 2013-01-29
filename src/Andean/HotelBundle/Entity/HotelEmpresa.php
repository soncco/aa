<?php

namespace Andean\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Andean\TrenBundle\Util\Util;

/**
 * @ORM\Entity(repositoryClass="Andean\HotelBundle\Entity\HotelRepository")
 * @ORM\Table(name="hotel_empresa")
 */
class HotelEmpresa
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $nombre;

    /**
    * @ORM\Column(type="string", length=100)
    */
    protected $slug;
    
    /**
     * @ORM\ManyToOne(targetEntity="Andean\HotelBundle\Entity\Categoria")
     */
    protected $categoria;
    
    /**
     * @ORM\ManyToOne(targetEntity="Andean\TrenBundle\Entity\Ciudad")
     */
    protected $ciudad;

    public function __toString()
    {
        return $this->getNombre();
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
    * Set nombre
    *
    * @param string $nombre
    */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);
    }

    /**
    * Get nombre
    *
    * @return string
    */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
    * Set slug
    *
    * @param string $slug
    */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
    * Get slug
    *
    * @return string
    */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * set Categoria
     * @param \Andean\HotelBundle\Entity\Categoria $categoria 
     */
    public function setCategoria(\Andean\HotelBundle\Entity\Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * get Categoria
     * @return Andean\HotelBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    /**
     * set Ciudad
     * @param \Andean\TrenBundle\Entity\Ciudad $ciudad
     */
    public function setCiudad(\Andean\TrenBundle\Entity\Ciudad $ciudad)
    {
        $this->ciudad = $ciudad;
    }

    /**
     * get Ciudad
     * @return Andean\HotelBundle\Entity\Ciudad 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }
}