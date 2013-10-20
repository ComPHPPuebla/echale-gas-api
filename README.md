# Echale Gas API

Esta API surge como parte del 
[Hackathón de Datos y Gobierno Abierto Puebla 2013](https://www.facebook.com/OpenDataPuebla).
El objetivo de la API es poder reportar gasolineras con mal servicio.

Para instalar la aplicación tienes dos opciones: clonar la aplicación e instalar las dependencias
con Composer:

    composer install

Para instalar Composer de forma global sigue las instrucciones de la
[documentación](http://getcomposer.org/doc/00-intro.md#globally).

O puedes instalar el proyecto usando Composer directamente:

    composer create-project comphppuebla/echale-gas-api echale-gas-api 0.0.2

Para comenzar a hacer pruebas debes crear el usuario de desarrollo en MySQL.

    GRANT ALL PRIVILEGES on echalegas.* TO echalegasuser@localhost IDENTIFIED BY '3chal3g4sus3r!';

Por último ejecuta el siguiente comando de [phing](http://www.phing.info/docs/guide/stable/)

    ./bin/phing app:reset-dev -propertyfile build.properties -verbose

Para hacer pruebas a la API puedes usar CURL, revisa por favor los ejemplos en la
[wiki](https://github.com/ComPHPPuebla/echale-gas-api/wiki/Testing-con-curl).