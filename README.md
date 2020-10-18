Sigue tu videoclub
========================

Instrucciones de uso
--------------------

(Antes de nada, necesitamos tener un servidor de base de datos en local, en mi caso uso xampp)

Paso 0. Descomprimir el archivo .rar y mover el parameter.yml dentro de la carpeta app/config

Paso 1. Installar Symfony 3.4 ( https://symfony.com/doc/3.4/setup.html )

Paso 2. Una vez instalado symfony, crear la base de datos con los comandos:

    php bin/console doctrine:database:create (Crea la base de datos)

    php bin/console doctrine:schema:update  --force (Aunque no es recomendable usar force en producción, en local no pasa nada)

    php bin/console iniciar:bbdd  (Generamos datos estandar en nuestra base de datos)

    php bin/console server:run  (Lanzamos el servidor)



Paso 3. Para usar las funciones necesarias nos apoyaremos en postman, importanto el siguiente link se pueden probar todas las funciones:
      https://www.getpostman.com/collections/f2aa7705e52ef871d3e7


Disfrutad :)




