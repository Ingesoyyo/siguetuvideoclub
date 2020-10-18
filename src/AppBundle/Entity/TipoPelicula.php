<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPelicula
 *
 * @ORM\Table(name="tipo_pelicula")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoPeliculaRepository")
 */
class TipoPelicula
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
     * @var int
     * Indica la agrupacion de dias en la que se paga cada unidad.
     * @ORM\Column(name="agrupacion", type="integer")
     */
    private $agrupacion;

    /**
     * @var int
     *
     * @ORM\Column(name="puntuacion", type="integer")
     */
    private $puntuacion;


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
     * @return TipoPelicula
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
     * Set agrupacion
     *
     * @param integer $agrupacion
     *
     * @return TipoPelicula
     */
    public function setAgrupacion($agrupacion)
    {
        $this->agrupacion = $agrupacion;

        return $this;
    }

    /**
     * Get agrupacion
     *
     * @return int
     */
    public function getAgrupacion()
    {
        return $this->agrupacion;
    }

    /**
     * Set puntuacion
     *
     * @param integer $puntuacion
     *
     * @return TipoPelicula
     */
    public function setPuntuacion($puntuacion)
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }

    /**
     * Get puntuacion
     *
     * @return int
     */
    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    /**
     * @ORM\OneToMany(targetEntity="Pelicula", mappedBy="tipo_pelicula")
     **/
    private $peliculas;


    /**
     * @ORM\OneToMany(targetEntity="Alquiler", mappedBy="tipo_pelicula")
     **/
    private $alquileres;



    public  function serializarObtejoJson(){
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'agrupacion' => $this->agrupacion,
            'puntuacion' => $this->puntuacion,
        );
    }

    public  function crearDesdeJson($json){

        $resultado = array(
            'correcto' => true,
            'error' => array()
        );

        if (isset($json['nombre'])){
            $this->setNombre($json['nombre']);
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'El nombre no existe, es imprescindible.';
        }

        if (isset($json['agrupacion'])){
            $this->setAgrupacion($json['agrupacion']);
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'La agrupacion de dias no se ha introducido, es imprescindible, es imprescindible.';
        }


        if (isset($json['puntuacion'])){
            $this->setPuntuacion($json['puntuacion']);
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'La puntuacion de fidelizacion no se ha introducido es imprescindible, es imprescindible.';
        }

         return $resultado;
    }


    public function actualizarDesdeJson($json){
        $resultado = array(
            'correcto' => true,
            'error' => array()
        );

        if (isset($json['nombre'])){
            $this->setNombre($json['nombre']);
        }

        if (isset($json['agrupacion'])){
            $this->setAgrupacion($json['agrupacion']);
        }

        if (isset($json['puntuacion'])){
            $this->setPuntuacion($json['puntuacion']);
        }

        return $resultado;
    }


    public function calculaPrecio($precio_unitario, $fecha_inicio, $fecha_fin){
        $numero_dias = $fecha_inicio->diff($fecha_fin)->days;
        $coste_total = $precio_unitario;

        if ( ( $numero_dias- $this->agrupacion) > 0){
            $coste_total += ( $numero_dias- $this->agrupacion)*$precio_unitario;
        }

        return $coste_total;


    }

}

