<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Alquiler;


class AlquilerController extends ManagerController{


	protected function generarAccionIndividual(){
        if ($this->accion == 'nuevo_alquiler') {
            $this->nuevo_alquiler(); 

        } else  if ($this->accion == 'puntos_fidelizacion'){
            $this->puntos_fidelizacion();


        } else{
        	$this->codigo_resultado = 401;
        	$this->error = "La acción no está definida";
        }
    }
	


    protected function nuevo_alquiler(){
        $em = $this->getDoctrine()->getManager();

        $error = array();
        $error_parametros = false;


        // Aplico los checks de datos entrantes
        if (isset($this->cuerpo['fecha_inicio'])){
            try{
                $fecha_inicio = new \DateTime($this->cuerpo['fecha_inicio']);
            }catch (\Exception $e){
                $error[] = "El formato de la fecha de inicio es invalida";
                $error_parametros = true;
            }
           
        }else{
            $error[] = "Error debe introducir la fecha de inicio";
            $error_parametros = true;
        }

        if (isset($this->cuerpo['fecha_fin'])){
            try{
                $fecha_fin = new \DateTime($this->cuerpo['fecha_fin']);
            }catch (\Exception $e){
                $error[] = "El formato de la fecha de finalizacion es invalida";
                $error_parametros = true;
            }
           
        }else{
            $error[] = "Error debe introducir la fecha de finalizacion";
            $error_parametros = true;
        }

        if (isset($this->cuerpo['id_cliente'])){
           $id_cliente = $this->cuerpo['id_cliente'];
        }else{
            $error[] = "Error debe introducir un cliente";
            $error_parametros = true;
        }

        if (isset($this->cuerpo['id_peliculas'])){
           $peliculas = $this->cuerpo['id_peliculas'];
        }else{
            $error[] = "Error debe introducir una lista de peliculas";
            $error_parametros = true;
        }

        // Si hay error lo devuelvo, en caso contrario continuo.
        if ($error_parametros){
            $this->codigo_resultado = 403;
            $this->error = "Error en los parametros: ";
            foreach ($error as $e){
                $this->error .= $e ." \n";
            }
        }else{
            
            $cliente_obj = $em->getRepository("AppBundle:Cliente")->findOneById($id_cliente);
            $peliculas_obj = $em->getRepository("AppBundle:Pelicula")->obtener_peliculas_lista($peliculas);
            if ($cliente_obj != null and $peliculas_obj ){
                $total_precio = 0;

                foreach ($peliculas_obj as $pelicula) {
                    $alquiler = new Alquiler();
                    $alquiler->nuevo_alquiler($fecha_inicio, $fecha_fin, $cliente_obj, $pelicula);
                    $em->persist($alquiler);

                    $total_precio += $alquiler->getTipoPelicula()->calculaPrecio($this->precio_unitario, $fecha_inicio, $fecha_fin);

                }
                $em->flush();

                $this->data['precio_final'] = $total_precio;
            }else{
                $this->codigo_resultado = 403;
                $this->error = "Error las peliculas y los clientes deben existir. ";
            }
            

        }


    }



    protected function puntos_fidelizacion(){


        $em = $this->getDoctrine()->getManager();

        if (isset($this->cuerpo['id_cliente'])){
           $id_cliente = $this->cuerpo['id_cliente'];
        }else{
            $this->codigo_resultado = 403;
            $this->error = "Error no ha elegido ningun: ";
        }

        $puntos_fidelizacion = $em->getRepository("AppBundle:Alquiler")->obtener_puntos_cliente($id_cliente);
        
        $this->data['puntos_fidelizacion'] = $puntos_fidelizacion;
        
    }
	
}