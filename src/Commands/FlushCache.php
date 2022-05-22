<?php

/*
|--------------------------------------------------------------------------
| FlushCache
|--------------------------------------------------------------------------
|
| Optimización de la Eliminacion de todos los caches de Laravel 8^.
| Autor: Raul Mauricio Uñate Castro
| Fecha: 20-12-2021
|
*/

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use App\Console\ArtisanCommandClass;

class FlushCache extends Command{

    /*
    |--------------------------------------------------------------------------
    | Identificación Comando.
    |--------------------------------------------------------------------------
    |
    | $signature = Nombre para Consola.
    | description = Descripción.
    |
    */

    protected $signature = 'FlushCache';
    protected $description = 'Ejecuta la limpieza de los Caches de [Laravel, Configuración, Vistas, Rutas, Toquen Caducados] y eliminación del LOG de errores del proyecto.';

    /*
    |--------------------------------------------------------------------------
    | Incio Ejecución de Comando.
    |--------------------------------------------------------------------------
    |
    | Logaritmo Comando.
    |
    */

    public function handle(){

        $this->line('Start FlushCache Artisan Utilities');
        $this->info('Inicio limpieza del Proyecto');

        /* Ajuste Storage | Logs */
        $this->info("Inicio Revisión Estructura Storage.");
        ArtisanCommandClass::DeleteLogs();
        $this->info("Revisión Estructura Storage Completa y corregida.");
        $this->info("Log del Proyecto Vaciado Correctamente.");

        /* Eliminacion Cache del proyecto */
        @ArtisanCommandClass::CallArtisan('cache');
        $this->info("Cache Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Configuracion */
        @ArtisanCommandClass::CallArtisan('config');
        $this->info("Cache de Configuración Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Vistas */
        @ArtisanCommandClass::CallArtisan('view');
        $this->info("Cache de Vistas Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Rutas */
        @ArtisanCommandClass::CallArtisan('route');
        $this->info("Cache de Rutas Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Tokkens */
        @ArtisanCommandClass::CallArtisan('auth');
        $this->info("Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos");

        /* Eliminacion Cache de Eventos */
        @ArtisanCommandClass::CallArtisan('event');
        $this->info("Cache de Eventos Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Eventos */
        @ArtisanCommandClass::CallArtisan('permission');
        $this->info("Cache de Permisos Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Queue */
        @ArtisanCommandClass::CallArtisan('queue');
        $this->info("Cache de Queue Eliminado del Proyecto Correctamente");

        /* Eliminacion Cache de Schedule */
        @ArtisanCommandClass::CallArtisan('schedule');
        $this->info("Cache de Schedule Eliminado del Proyecto Correctamente");

        /* Optimizar */
        @ArtisanCommandClass::CallArtisan('optimize');
        $this->info("Proyecto Optimizado al 100%");

        /* Mensaje Final */
        $this->info('Proceso ejecutado con Exito!');

        /* Cierre */
        $this->line('End FlushCache Artisan Utilities');
    }
}
