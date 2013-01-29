<?php

namespace Andean\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Andean\TrenBundle\Util\Util;

/**
* @ORM\Entity
*/
class Acomodacion
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
}