<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 *   El manager se encargará de toodo lo relacionado con la gestión, tendrá algunas acciones predefinidas que nos ahorrará
 * multiplicar trabajo.
 */
class ManagerController extends BaseController
{
    protected $bundle = null;
    protected $entidad = null;

    protected $accion = null;
    protected $nombre_entidad = null;
    protected $precio_unitario = 3;


    public function postAction(){
        $this->bundle = $this->getAttributes()['bundle'];
        $this->entidad = $this->getAttributes()['entidad'];
        $this->accion = $this->getAttributes()['accion'];

        $aux_entidad = explode('\\', $this->entidad);
        $this->nombre_entidad = $aux_entidad[count($aux_entidad)-1];
        $this->generarAccion();

        return $this->generarSalida();
    }


    /**
     *   Acciones generales disponibles:
     *      - listar
     *      - ver_detalle
     *      - crear_nuevo
     *      - Actualizar
     *
     */
    protected function generarAccion(){
        $this->precio_unitario = 3;

        if ($this->accion == 'listar') {
            $this->listar(); 

        } else  if ($this->accion == 'crear'){
            $this->crear_nuevo();


        } else  if ($this->accion == 'actualizar'){
            $this->actualizar();


        }else{
           $this->generarAccionIndividual();
        }
    }

    // Este metodo se sobrescribe en las clases hijos para puedan añadir sus propias acciones.
    protected function generarAccionIndividual(){
        $this->codigo_resultado = 401;
        $this->error = "La acción no está definida";
    }


    protected function listar(){
        $em = $this->getDoctrine()->getManager();
        $lista_elementos = $em->getRepository("$this->bundle:$this->nombre_entidad")->findAll();

        $elementos_serializados = array();
        foreach ($lista_elementos as $elemento){
            $elementos_serializados[] = $elemento->serializarObtejoJson();
        }
        $this->data = $elementos_serializados;
    }


    protected function crear_nuevo(){
        $em = $this->getDoctrine()->getManager();
        $elemento = new $this->entidad();
        $resultado = $elemento->crearDesdeJson($this->cuerpo);

        if ($resultado['correcto'] == true){
            $em->persist($elemento);

            try{
                $em->flush();
            }catch (\Exception $e){
                $this->codigo_resultado = 555;
                $this->error = "Error al guardar la clase $this->entidad: " . $e->getMessage();
            }
        }else{
            $this->codigo_resultado = 403;
            $this->error = "Error en los parametros: ";
            foreach ($resultado['error'] as $error){
                $this->error .= $error ." \n";
            }
        }

    }

    protected function actualizar(){
        $em = $this->getDoctrine()->getManager();
        if (!isset($this->cuerpo['id'])){
            $this->codigo_resultado = 403;
            $this->error = "Error en los parametros: \n Falta el campo obligatorio id";
        }else{
            $id = $this->cuerpo['id'];
            $elemento = $em->getRepository("$this->bundle:$this->nombre_entidad")->findOneById($id);
            $resultado = $elemento->actualizarDesdeJson($this->cuerpo);
            if ($resultado['correcto'] == true){
                $em->persist($elemento);

                try{
                    $em->flush();
                }catch (\Exception $e){
                    $this->codigo_resultado = 555;
                    $this->error = "Error al guardar la clase $this->entidad: " . $e->getMessage();
                }
            }else{
                $this->codigo_resultado = 403;
                $this->error = "Error en los parametros: ";
                foreach ($resultado['error'] as $error){
                    $this->error .= $error ." \n";
                }
            }
        }
    }

    /*
     * Para terminar esta estructura, aún es necesario definir acciones básicas generales y en cada controlador
     * se generarán acciones espcíficas.
     *
     * */
}