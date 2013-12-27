# Échale Gas API

Esta API surge como parte del 
[Hackathón de Datos y Gobierno Abierto Puebla 2013](https://www.facebook.com/OpenDataPuebla).
El objetivo de la API es poder reportar gasolineras con mal servicio.

Para instalar la API necesitas instalar la [máquina virtual](https://github.com/ComPHPPuebla/echale-gas-vm)
del proyecto. La máquina virtual ya contiene el código de este repositorio y sólo es necesario
instalar las dependencias con [Composer](http://getcomposer.org/):

```bash
$ composer install
```

La máquina virtual también tiene instalada la base de datos de desarrollo: `echalegas`. El usuario 
es `echalegasuser` y la contraseña es `3chal3g4sus3r!`.

Por último, ejecuta el siguiente comando de [phing](http://www.phing.info/docs/guide/stable/)

```bash
$ ./bin/phing app:reset-dev -propertyfile build.properties -verbose
```

Puedes ejecutar los tests unitarios y funcionales con los siguiente comandos:

```bash
$ ./bin/phing db:setup-testing -verbose
$ ./bin/phing test:all -verbose
```

Puedes probar la API y revisar la documentación en la carpeta `docs`. El host virtual
es `api.echalegas.dev` la URL sería:

    http://api.echalegas.dev/docs/ 

Para hacer pruebas desde línea de comando a la API puedes usar CURL, revisa por favor los ejemplos
en la [wiki](https://github.com/ComPHPPuebla/echale-gas-api/wiki/Testing-con-curl).
