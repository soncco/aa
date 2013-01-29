<?php

namespace Andean\TrenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Andean\TrenBundle\Util\Util;

/**
 * @ORM\Entity(repositoryClass="Andean\TrenBundle\Entity\TrenRepository")
 * @ORM\Table(name="tren_tipo")
 */
class TrenTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Andean\TrenBundle\Entity\TrenEmpresa")
     */
    protected $empresa;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $nombre;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $slug;

    public function __toString()
    {
        return $this->getNumero() . ' - ' .$this->getEmpresa() . ' - ' .$this->getNombre();
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
     * Set numero
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
    
    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
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
     * set Empresa
     * @param \Andean\TrenBundle\Entity\TrenEmpresa $empresa 
     */
    public function setEmpresa(\Andean\TrenBundle\Entity\TrenEmpresa $empresa) {
      $this->empresa = $empresa;
    }
    
    /**
     * Get Empresa
     * @return Andean\TrenBundle\Entity\TrenEmpresa
     */
    public function getEmpresa() {
      return $this->empresa;
    }
}