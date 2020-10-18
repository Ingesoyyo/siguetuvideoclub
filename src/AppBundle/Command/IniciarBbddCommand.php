<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


use AppBundle\Entity\Cliente;
use AppBundle\Entity\TipoPelicula;
use AppBundle\Entity\Pelicula;




class IniciarBbddCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('iniciar:bbdd')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $em = $this->getContainer()->get('doctrine')->getManager();

        // Inicializo TipoPeliculas
        $tipo_pelicula_nueva = new TipoPelicula();
        $tipo_pelicula_nueva->crearDesdeJson(
            array(
                "nombre"=>"Nuevo lanzamiento",
                "agrupacion"=>"1",
                "puntuacion"=>"2",
            )
        );
        $em->persist($tipo_pelicula_nueva);

        
        $tipo_pelicula_normales = new TipoPelicula();
        $tipo_pelicula_normales->crearDesdeJson(
            array(
                "nombre"=>"Pelicula normal",
                "agrupacion"=>"3",
                "puntuacion"=>"1",
            )
        );
        $em->persist($tipo_pelicula_normales);


        $tipo_pelicula_viejas = new TipoPelicula();
        $tipo_pelicula_viejas->crearDesdeJson(
            array(
                "nombre"=>"Pelicula vieja",
                "agrupacion"=>"5",
                "puntuacion"=>"1",
            )
        );

        $em->persist($tipo_pelicula_viejas);


        // Inicializo los clientes

        $client1 = new Cliente();
        $client1->crearDesdeJson(
            array(
                "nombre"=>"Aitor",
                "apellido1"=>"Prueba",
                "apellido2"=>"uno",
                "dni"=>"93016305G",
                "email"=>"usuario@mail.com",
            )
        );
        $em->persist($client1);


        $client2 = new Cliente();
        $client2->crearDesdeJson(
            array(
                "nombre"=>"Basilio",
                "apellido1"=>"Prueba",
                "apellido2"=>"dos",
                "dni"=>"59587168X",
                "email"=>"usuario2@mail.com",
            )
        );
        $em->persist($client2);




        // Inicializacion de Peliculas

        $pelicula1 = new Pelicula();
        $pelicula1->crearDesdeJson(
            array(
                "nombre"=>"Mulan Live Action"
            ), 
            $tipo_pelicula_nueva
        );
        $em->persist($pelicula1);


        $pelicula2 = new Pelicula();
        $pelicula2->crearDesdeJson(
            array(
                "nombre"=>"Spiderman Homecomming"
            ), 
            $tipo_pelicula_normales
        );
        $em->persist($pelicula2);


        $pelicula3 = new Pelicula();
        $pelicula3->crearDesdeJson(
            array(
                "nombre"=>"Ready player One"
            ), 
            $tipo_pelicula_normales
        );
        $em->persist($pelicula3);



        $pelicula4 = new Pelicula();
        $pelicula4->crearDesdeJson(
            array(
                "nombre"=>"Dos policias Rebeldes"
            ), 
            $tipo_pelicula_viejas
        );
        $em->persist($pelicula4);



        $pelicula5 = new Pelicula();
        $pelicula5->crearDesdeJson(
            array(
                "nombre"=>"No me grites que no te veo"
            ), 
            $tipo_pelicula_viejas
        );
        $em->persist($pelicula5);

        
        // Guyardamos
        $em->flush();

    }

}
