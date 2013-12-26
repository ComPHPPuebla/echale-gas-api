# Echale Gas API

Esta API surge como parte del 
[Hackathón de Datos y Gobierno Abierto Puebla 2013](https://www.facebook.com/OpenDataPuebla).
El objetivo de la API es poder reportar gasolineras con mal servicio.

Para instalar la aplicación tienes dos opciones: clonar la aplicación e instalar las dependencias
con Composer:

```bash
$ composer install
```

Para instalar Composer de forma global sigue las instrucciones de la
[documentación](http://getcomposer.org/doc/00-intro.md#globally).

O puedes instalar el proyecto usando Composer directamente:

```bash
$ composer create-project comphppuebla/echale-gas-api echale-gas-api 0.1.0
```

Para comenzar a hacer pruebas debes crear el usuario de desarrollo en MySQL.

```sql
GRANT ALL PRIVILEGES on echalegas.* TO echalegasuser@localhost IDENTIFIED BY '3chal3g4sus3r!';
```

Por último ejecuta el siguiente comando de [phing](http://www.phing.info/docs/guide/stable/)

```bash
$ ./bin/phing app:reset-dev -propertyfile build.properties -verbose
```

Puedes ejecutar los tests unitarios y funcionales con los siguiente comandos:

```bash
$ ./bin/phing db:setup-testing -verbose
$ ./bin/phing test:all -verbose
```

Puedes probar la API y revisar la documentación en la carpeta `docs`. Suponiendo que tu host virtual
es `api.echalegas.dev` la URL sería:

    http://api.echalegas.dev/docs/ 

Para hacer pruebas desde línea de comando a la API puedes usar CURL, revisa por favor los ejemplos
en la [wiki](https://github.com/ComPHPPuebla/echale-gas-api/wiki/Testing-con-curl).
