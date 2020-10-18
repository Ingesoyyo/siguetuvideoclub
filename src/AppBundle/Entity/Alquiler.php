<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alquiler
 *
 * @ORM\Table(name="alquiler")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlquilerRepository")
 */
class Alquiler
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime")
     */
    private $fechaFin;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return Alquiler
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Alquiler
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }


    /**
     * @ORM\ManyToOne(targetEntity="TipoPelicula", inversedBy="alquileres")
     * @ORM\JoinColumn(name="tipo_pelicula_id", referencedColumnName="id")
     */
    private $tipo_pelicula;


    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="alquileres")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;



    /**
     * @ORM\ManyToOne(targetEntity="Pelicula", inversedBy="alquileres")
     * @ORM\JoinColumn(name="pelicula_id", referencedColumnName="id")
     */
    private $pelicula;



    /**
     * Set TipoPelicula
     *
     * @return Alquiler
     */
    public function setTipoPelicula($tipo_pelicula){
        $this->tipo_pelicula = $tipo_pelicula;

        return $this;
    }

    /**
     * Get TipoPelicula
     *
     * @return \TipoPelicula
     */
    public function getTipoPelicula(){
        return $this->tipo_pelicula;
    }


    /**
     * Set Cliente
     *
     * @return Alquiler
     */
    public function setCliente($cliente){
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get Cliente
     *
     * @return \Cliente
     */
    public function getCliente(){
        return $this->cliente;
    }


    /**
     * Set Pelicula
     *
     * @return Alquiler
     */
    public function setPelicula($pelicula){
        $this->pelicula = $pelicula;

        return $this;
    }

    /**
     * Get Pelicula
     *
     * @return \Pelicula
     */
    public function getPelicula(){
        return $this->pelicula;
    }



    public function nuevo_alquiler($fecha_inicio, $fecha_fin, $cliente, $pelicula){
        $this->setFechaInicio($fecha_inicio);
        $this->setFechaFin($fecha_fin);
        $this->setCliente($cliente);
        $this->setPelicula($pelicula);
        $this->setTipoPelicula($pelicula->getTipoPelicula());

    }



}

