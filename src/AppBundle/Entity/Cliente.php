<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClienteRepository")
 */
class Cliente
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
     * @var string
     *
     * @ORM\Column(name="apellido1", type="string", length=255)
     */
    private $apellido1;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido2", type="string", length=255)
     */
    private $apellido2;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, unique=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime")
     */
    private $fechaRegistro;


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
     * @return Cliente
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
     * Set apellido1
     *
     * @param string $apellido1
     *
     * @return Cliente
     */
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    /**
     * Get apellido1
     *
     * @return string
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * Set apellido2
     *
     * @param string $apellido2
     *
     * @return Cliente
     */
    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    /**
     * Get apellido2
     *
     * @return string
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Cliente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Cliente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Cliente
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }


    /**
     * @ORM\OneToMany(targetEntity="Alquiler", mappedBy="cliente")
     **/
    private $alquileres;

    public  function serializarObtejoJson(){
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'dni' => $this->dni,
            'email' => $this->email,
            'fechaRegistro' => $this->fechaRegistro,
        );
    }


    private function validar_dni($dni){
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);
        $valido = false;;
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
            $valido=true;
        }
        return $valido;
    }

    private function validar_email($email){
        return (false !== filter_var("usu_ario@gmail.com", FILTER_VALIDATE_EMAIL));
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

        if (isset($json['apellido1'])){
            $this->setApellido1($json['apellido1']);
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'La agrupacion de dias no se ha introducido, es imprescindible, es imprescindible.';
        }


        if (isset($json['apellido2'])){
            $this->setApellido2($json['apellido2']);
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'La puntuacion de fidelizacion no se ha introducido es imprescindible, es imprescindible.';
        }


        if (isset($json['dni'])){
            if ($this->validar_dni($json['dni'])){
                $this->setDni($json['dni']);
            }else{
                $resultado['correcto'] = false;
                $resultado['error'][] = 'El formato del dni no es valido.';
            }
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'El nombre no existe, es imprescindible.';
        }

        if (isset($json['email'])){
            if ($this->validar_email($json['email'])){
                $this->setEmail($json['email']);
            }else{
                $resultado['correcto'] = false;
                $resultado['error'][] = 'El formato del email no es valido.';
            }
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'La agrupacion de dias no se ha introducido, es imprescindible, es imprescindible.';
        }


        $this->setFechaRegistro(new \DateTime());
        

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

        if (isset($json['apellido1'])){
            $this->setApellido1($json['apellido1']);
        }


        if (isset($json['apellido2'])){
            $this->setApellido2($json['apellido2']);
        }


        if (isset($json['dni'])){
            $this->setDni($json['dni']);
        }

        if (isset($json['email'])){
            $this->setEmail($json['email']);
        }

        return $resultado;
    }

}

