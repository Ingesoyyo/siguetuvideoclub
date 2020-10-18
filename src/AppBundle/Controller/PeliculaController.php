<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PeliculaController extends ManagerController{


	protected function generarAccionIndividual(){
        if ($this->accion == 'listar_por_tipo') {
            $this->listar_por_tipo(); 

        }else{
        	$this->codigo_resultado = 401;
        	$this->error = "La acción no está definida";
        }
    }
	
	protected function listar_por_tipo(){
		$em = $this->getDoctrine()->getManager();
		if (isset($this->cuerpo['id_tipo_pelicula'])){
        	$lista_elementos = $em->getRepository("$this->bundle:$this->nombre_entidad")->buscar_tipo_pelicula($this->cuerpo['id_tipo_pelicula']);
	    	$elementos_serializados = array();
	        foreach ($lista_elementos as $elemento){
	            $elementos_serializados[] = $elemento->serializarObtejoJson();
	        }
	        $this->data = $elementos_serializados;
    	}else{
    		$this->codigo_resultado = 403;
            $this->error = "Error debe elegir el id del tipo de pelicula";
    	}

       
	}

	protected function crear_nuevo(){
        $em = $this->getDoctrine()->getManager();
        $pelicula = new $this->entidad();


		$resultado = array(
            'correcto' => true,
            'error' => array()
        );


		if (!isset($this->cuerpo['nombre'])){
            $resultado['correcto'] = false;
            $resultado['error'][] = 'El nombre no existe, es imprescindible.';
        }

        if (isset($this->cuerpo['id_tipo_pelicula'])){
            $tipo_pelicula = $em->getRepository("AppBundle:TipoPelicula")->findOneById($this->cuerpo['id_tipo_pelicula']);
        }else{
            $resultado['correcto'] = false;
            $resultado['error'][] = 'El nombre no existe, es imprescindible.';
        }

        if ($resultado['correcto'] == true){
        	$pelicula->crearDesdeJson($this->cuerpo, $tipo_pelicula);
            $em->persist($pelicula);

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
            $pelicula = $em->getRepository("$this->bundle:$this->nombre_entidad")->findOneById($id);

			$resultado = array(
	            'correcto' => true,
	            'error' => array()
	        );


	        if (isset($this->cuerpo['id_tipo_pelicula'])){
	            $tipo_pelicula = $em->getRepository("AppBundle:TipoPelicula")->findOneById($this->cuerpo['id_tipo_pelicula']);
	        }else{
	            $tipo_pelicula = null;
	        }

            
            if ($resultado['correcto'] == true){
            	$pelicula->actualizarDesdeJson($this->cuerpo, $tipo_pelicula);
                $em->persist($pelicula);

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
}