<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

// Tipo pelicula
$collection->add('tipo_pelicula_listar', new Route('/tipopelicula/listar', array(
    '_controller' => 'AppBundle:Manager:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'listar',
    'entidad' => \AppBundle\Entity\TipoPelicula::class
)));

$collection->add('tipo_pelicula_crear', new Route('/tipopelicula/crear', array(
    '_controller' => 'AppBundle:Manager:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'crear',	
    'entidad' => \AppBundle\Entity\TipoPelicula::class
)));


$collection->add('tipo_pelicula_actualizar', new Route('/tipopelicula/actualizar', array(
    '_controller' => 'AppBundle:Manager:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'actualizar',	
    'entidad' => \AppBundle\Entity\TipoPelicula::class
)));



// Cliente

$collection->add('cliente_listar', new Route('/cliente/listar', array(
    '_controller' => 'AppBundle:Manager:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'listar',
    'entidad' => \AppBundle\Entity\Cliente::class
)));

$collection->add('cliente_crear', new Route('/cliente/crear', array(
    '_controller' => 'AppBundle:Manager:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'crear',	
    'entidad' => \AppBundle\Entity\Cliente::class
)));


$collection->add('cliente_actualizar', new Route('/cliente/actualizar', array(
    '_controller' => 'AppBundle:Manager:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'actualizar',	
    'entidad' => \AppBundle\Entity\Cliente::class
)));

//  Pelicula


$collection->add('pelicula_listar', new Route('/pelicula/listar', array(
    '_controller' => 'AppBundle:Pelicula:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'listar',
    'entidad' => \AppBundle\Entity\Pelicula::class
)));


$collection->add('pelicula_listar_por_tipo', new Route('/pelicula/listar/tipo/pelicula', array(
    '_controller' => 'AppBundle:Pelicula:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'listar_por_tipo',
    'entidad' => \AppBundle\Entity\Pelicula::class
)));

$collection->add('pelicula_crear', new Route('/pelicula/crear', array(
    '_controller' => 'AppBundle:Pelicula:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'crear',	
    'entidad' => \AppBundle\Entity\Pelicula::class
)));


$collection->add('pelicula_actualizar', new Route('/pelicula/actualizar', array(
    '_controller' => 'AppBundle:Pelicula:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'actualizar',	
    'entidad' => \AppBundle\Entity\Pelicula::class
)));


// Alquiler 


$collection->add('alquilar_peliculas', new Route('/alquilar/peliculas', array(
    '_controller' => 'AppBundle:Alquiler:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'nuevo_alquiler',	
    'entidad' => \AppBundle\Entity\Alquiler::class
)));


$collection->add('alquilar_puntos_fidelizacion', new Route('alquilar/puntos/fidelizacion', array(
    '_controller' => 'AppBundle:Alquiler:dispatch',
    'bundle' => 'AppBundle',
    'accion' => 'puntos_fidelizacion',	
    'entidad' => \AppBundle\Entity\Alquiler::class
)));


return $collection;