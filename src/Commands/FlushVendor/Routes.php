<?php

/*
|--------------------------------------------------------------------------
| Archivos
|--------------------------------------------------------------------------
|
| En esta seccion del Script, solo se hace gestión de Archivos, no de carpetas.
| Se debe estabeccer el Oigen y el Destino de cada fichero en el mismo orden.
|
*/

# RUTAS SOLO REMPLAZO DE ARCHIVOS
$routeFile = [

    /*
    |--------------------------------------------------------------------------
    | Nombre de los Archivos Modificados
    |--------------------------------------------------------------------------
    |
    | En esta seccion debe listarse los archivos que se deberan remplazar en el Vendor.
    | Los archivos deben estar dentro de la carpeta "Files"
    | Garantizar poner el nombre completo correctamente con su extension.
    | ------------- Ejemplo: archivo.php
    |
    */

    'origen' => [
        'miarchivo.php',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rura de los Archivos a remplazar
    |--------------------------------------------------------------------------
    |
    | En esta seccion se deben listar las rutas donde se encuentran los archivos originales a remplazar.
    | Los documentos aqui listados, seran eliminados y remplazados por los listados en origen.
    |
    | La ruta debe ser la correspondiente dentro de vendor/...
    | ------------- Ejemplo: libreria/archivo.php
    | Fijese que el archivo deberia contener el mismo nombre de Origen.
    | De no ser asi, el archivo se alojará con el nombre puesto en esta sección.
    |
    */

    'destino' => [
        // 'archivo.php',
    ]

];

/*
|--------------------------------------------------------------------------
| Archivos
|--------------------------------------------------------------------------
|
| En esta seccion del Script, solo se hace gestión de Archivos, no de carpetas.
| Se debe estabeccer el Oigen y el Destino de cada fichero en el mismo orden.
|
*/

# RUTAS SOLO REMPLAZO DE CARPETAS
$routeDir = [

    /*
    |--------------------------------------------------------------------------
    | Nombre de las Carpetas Modificadas
    |--------------------------------------------------------------------------
    |
    | En esta seccion debe listarse las  carpetas que deberan remplazarce en el Vendor.
    | Los directorios deben estar dentro de la carpeta "Directories"
    | Garantizar poner el nombre completo correctamente de la carpeta.
    | ------------- Ejemplo: micarpeta
    */
    'origen' => [
        // 'micarpeta',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rura de los Directorios a remplazar
    |--------------------------------------------------------------------------
    |
    | En esta seccion se deben listar las rutas donde se encuentran los directorios a remplazar.
    | Los directorios aqui listados, seran eliminados y remplazados por los listados en origen.
    |
    | La ruta debe ser la correspondiente dentro de vendor/...
    | ------------- Ejemplo: libreria/micarpeta
    | Fijese que el directorio deberia contener el mismo nombre de Origen.
    | De no ser asi, el directorio se alojará con el nombre puesto en esta sección.
    |
    */
    'destino' => [
        // 'libreria/micarpeta',
    ]

];
