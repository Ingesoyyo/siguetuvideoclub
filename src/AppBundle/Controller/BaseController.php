<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller{

    protected $contexto;
    protected $request;

    //Lectura
    protected $cuerpo;

    // Escritura
    protected $codigo_resultado=200;
    protected $data = array();
    protected $error = "";
    /*

        //// ESTRUCTURA ENTRADA ///
        
        // Aunque no tenga autenticación lo dejo preparado
        "autenticacion": {
        },
        "cuerpo":{
            ******
        }


        //// ESTRUCTURA SALIDA ////

        {
            "codigo"=> "999",
            "data" => {},
            "error" =>"El método " . $request->getMethod() . " no está soportado)"
        }




     */


    /*
    Códigos de errores


    // 4XX Errores de datos
    400: Estructura de petición mal formada.
    401: Error de autenticacion. Estructura mal formada
    402: Error de autenticación. Usuario no valido.
    403: Faltan campos obligatorios
    404: Formato no valido.
    405: Error, el usuario emisor y el autenticado no coinciden
    410: Error al enviar el mensaje


    // Errores de sistema
    555: Error al guardar en base de datos

    // 9XX Accesos inexistentes
    999: método no soportado



     */

    
    protected function autenticacion(){
        // Siempre se autentica
        return true;
    }


    protected function lecturaEntrada(){


        $peticion = $this->getContentData();
        if (isset($peticion['autenticacion']) and isset($peticion['cuerpo']) ){

            $this->autenticacion = $peticion['autenticacion'];
            $this->cuerpo = $peticion['cuerpo'];

        }else{
            $this->codigo_resultado = 400;
            $this->error = "El formato de entrada no es válido.";
        }

    }

    protected function generarSalida(){
        /*
        return new JsonResponse(
            array(
                "codigo"=> $this->codigo_resultado,
                "data" => $this->data,
                "error" =>$this->error
            )
        );
        */

        $response = new JsonResponse();

        $response->setContent(json_encode(
            array(
                "codigo"=> $this->codigo_resultado,
                "data" => $this->data,
                "error" =>$this->error
            )
        ));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getPostRequestData(){
        return $this->request->request->all();
    }

    public function getContentData() {
        return json_decode($this->request->getContent(), true);

    }

    public function getAttributes(){
        return $this->request->attributes->all();
        //return json_decode($this->request->getContent());

    }

    public function getQuery(){
        return $this->request->query->all();
        //return json_decode($this->request->getContent());

    }

    public function dispatchAction(Request $request){

        $this->request = $request;

        if($request->getMethod() == 'POST' ){

            try{
                $this->lecturaEntrada();

                if ($this->autenticacion()){
                    $this->postAction();
                }else{
                    $this->codigo_resultado = 402;
                    $this->error = "No ha podido autenticarse por un token incorrecto.";
                }

            }catch (\Exception $e){
                $this->codigo_resultado = 402;
                $this->error = $e->getMessage();
            }

        } else if($request->getMethod() == 'OPTIONS'){
            // Este caso lo usa google para ver si hay permisos
        }else{
           $this->getAction();
        }

        return $this->generarSalida();




    }

    public function getAction(){
        $this->codigo_resultado = 999;
        $this->error = "El método  no está soportado.";
    }


    public function postAction(){
        $this->codigo_resultado = 999;
        $this->error = "El método  no está soportado.";
    }
}
