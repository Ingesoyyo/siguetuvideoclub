<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pelicula
 *
 * @ORM\Table(name="pelicula")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeliculaRepository")
 */
class Pelicula
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pelicula
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
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
     * @ORM\ManyToOne(targetEntity="TipoPelicula", inversedBy="peliculas")
     * @ORM\JoinColumn(name="tipo_pelicula_id", referencedColumnName="id")
     */
    private $tipo_pelicula;


    /**
     * @ORM\OneToMany(targetEntity="Alquiler", mappedBy="pelicula")
     **/
    private $alquileres;


    public function setTipoPelicula($tipo_pelicula)
    {
        $this->tipo_pelicula = $tipo_pelicula;

        return $this;
    }


    /**
     * Get tipo_pelicula
     *
     * @return string
     */
    public function getTipoPelicula()
    {
        return $this->tipo_pelicula;
    }




    public  function serializarObtejoJson(){
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'tipo_pelicula' => $this->tipo_pelicula->getNombre(),
        );
    }

    public  function crearDesdeJson($json, $tipo_pelicula){

        $resultado = array(
            'correcto' => true,
            'error' => array()
        );

        $this->setNombre($json['nombre']);
        $this->setTipoPelicula($tipo_pelicula);
        

         return $resultado;
    }


    public function actualizarDesdeJson($json, $tipo_pelicula){
        $resultado = array(
            'correcto' => true,
            'error' => array()
        );

        if (isset($json['nombre'])){
            $this->setNombre($json['nombre']);
        }
        if ($tipo_pelicula!= null){
            $this->setTipoPelicula($tipo_pelicula);
        }
        
        return $resultado;
    }
}

