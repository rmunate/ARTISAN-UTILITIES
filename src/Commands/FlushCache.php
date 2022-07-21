<?php

/*
|--------------------------------------------------------------------------
| FlushCache
|--------------------------------------------------------------------------
|
| Optimización de la Eliminacion de todos los caches de Laravel 8^.
| Autor: Raul Mauricio Uñate Castro
| V 1.0: 20-12-2021
| V 1.2: 01-05-2022
| V 2.0: 19-07-2022 (Reescrito)
|--------------------------------------------------------------------------
|
*/

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\ArtisanUtilities;

class FlushCache extends Command {

    /**
     * Nombre del Comando
     * @var string
     */
    protected $signature = 'FlushCache';

    /**
     * Descripción del Comando
     * @var string
     */
    protected $description = 'Ejecuta la limpieza de los Caches de Laravel[Configuración, Vistas, Rutas, Toquen Caducados entre otros] adicional elimina el LOG de errores del proyecto.';

    /**
     * Codigo del Comando
     * @return Void
     */
    public function handle(){

        /* Omitir Errores */
        ArtisanUtilities::errorHidden();

        $this->line(ArtisanUtilities::$start);
        $this->info('Inicio limpieza del Proyecto');

        /* Ajuste Storage & Logs */
        $this->info("Inicio Revisión Estructura Storage.");
        ArtisanUtilities::DefaultStorage();
        $this->info("Revisión Estructura Storage Completa y Corregida.");
        $this->info("Log de Errores del Proyecto Vaciado Correctamente.");

        /* Eliminacion Cache del proyecto */
        /**
         * Comandos Artisan a Ejecutar
         * Mismo Orden de Ejecucion
         * @var array
         */
        $commands = [
            'cache' => 'Cache Eliminado del Proyecto Correctamente',
            'config' => 'Cache de Configuración Eliminado del Proyecto Correctamente',
            'view' => 'Cache de Vistas Eliminado del Proyecto Correctamente',
            'route' => 'Cache de Rutas Eliminado del Proyecto Correctamente',
            'auth' => 'Cache de Tokens Caducados Eliminado del Proyecto Correctamente en base de datos',
            'event' => 'Cache de Eventos Eliminado del Proyecto Correctamente',
            'permission' => 'Cache de Permisos Eliminado del Proyecto Correctamente',
            'queue' => 'Cache de Cola Eliminado del Proyecto Correctamente',
            'schedule' => 'Cache de Calendario Eliminado del Proyecto Correctamente',
            'optimize' => 'Proyecto Optimizado'
        ];
        foreach ($commands as $command => $comment) {
            @ArtisanUtilities::Call($command);
            $this->info($comment);
        }

        /* Cierre */
        $this->info(ArtisanUtilities::$last);
        $this->line(ArtisanUtilities::$end);

        /* Activacion Errores */
        ArtisanUtilities::errorShow();
    }
}
