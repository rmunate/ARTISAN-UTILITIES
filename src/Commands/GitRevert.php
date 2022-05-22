<?php

/*
|--------------------------------------------------------------------------
| Comando para Ejecutar GitRevert
|--------------------------------------------------------------------------
|
| Este comando simplifica la ejecucion de los comandos Git para reversar cambios.
| Autor: Raul Mauricio Uñate Castro
| Fecha: 20-12-2021
|
*/

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use App\Console\ArtisanCommandClass;

class GitRevert extends Command{

    /*
    |--------------------------------------------------------------------------
    | Identificación Comando.
    |--------------------------------------------------------------------------
    |
    | $signature = Nombre para Consola.
    | description = Descripción.
    |
    */

    protected $signature = 'GitRevert {--log=}';
    protected $description = 'Reversar Cambios en el directorio de destino';

    /*  Constructor de la Clase */
    public function __construct(){
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | Incio Ejecución de Comando.
    |--------------------------------------------------------------------------
    |
    | Logaritmo Comando.
    |
    */
    public function handle(){

        /* Inicio Comando */
        $this->line('Start GitRevert Artisan Utilities');

        /* Arreglo de Commits */
        $arrayCommits = ArtisanCommandClass::GitCommits();

        /* Cuenta de commits */
        $countCommits = count($arrayCommits);

        /* Se quita un comit porque la ultima llave por defecto viene vacio */
        $msjCommits = $countCommits - 1;

        /* Mensaje con la cantidad de commits del repositorio */
        $this->info('El repositorio cuenta con un total de ' . $msjCommits . ' commits aplicados.');

        /* Eliminar los comits que llegasen a aparecer repetidos */
        $uniqueCommits = array_unique($arrayCommits);

        /* Validar si se determino por parte del usuario la cantidad de Commits a mostrar en pantalla. */
        /* Valida que este seteada la opcion y que sea superior a 0 */
        if (isset($this->option()["log"]) && strlen($this->option()["log"] > 0)) {

            /* Por defecto se recibe en String, se convierte en INT y se valida que sea superior a 1 */
            if (intval($this->option()["log"]) >= 1) {

                /* Al cumplir con las condiciones, se agrega el valor a la cantidad. */
                $cantidadPre = intval($this->option()["log"]);

                /* Se comparan la cantidad de commits para determinar cuantos mostrar. */
                if ($cantidadPre < $countCommits) {
                    /* Se lista la cantidad definida por el usuario. */
                    $cantidad = $cantidadPre;
                    $this->info('Se listaran un maximo de ' . $cantidad . ' commits.');

                } else {
                    /* Se lista el total de commits ya que el numero ingresado es superior al existente */
                    $cantidad = $countCommits - 1;
                    $this->info('Se listaran un maximo de ' . $cantidad . ' commits aplicados ya que el valor ingresado supera el real existente.');

                }

            }

        } else {

            /* Si el usuario no define la cantidad, se listan por defecto 10 commits*/
            $cantidad = 10;
            $this->info('Se listaran un maximo de ' . $cantidad . ' commits aplicados ya que no se definio una cantidad a traves de la opcion --log=');

        }

        /* Se extrae la cantidad de Commits a mostrar */
        $arrayCommits_t = array_slice($uniqueCommits, 0, ($cantidad));

        /* Saneamiento del Log */
        $arrayCommitsList = ArtisanCommandClass::GitLogs($arrayCommits_t);

        /* Pregunta de Seleccion */
        $this->line('Revisa Detenidamente.');

        $preguntaRevert = $this->choice(
            'Selecciona El Cambio a Restarurar.',
            $arrayCommitsList
        );

        /* Cambio definido para revertir */
        $cambio = substr($preguntaRevert, 0, 8);

        /* Arreglo con los Datos del Show */
        $arrayShowCommits = ArtisanCommandClass::GitShow($cambio);

        /* Extraer los tres datos relevantes del cambio
        * Consecutivo
        * Fecha
        * Autor
        */
        $salidaShowCommits = array_slice($arrayShowCommits, 0, 3);

        $this->line('Detalles Del Commit Seleccionado:');

        /* Detalles del commit a reversar */
        foreach ($salidaShowCommits as $msjCommit) {
            $this->info($msjCommit);
        }

        /* Comentario del cambio a reversar */
        $this->info('Mensaje Manual Del Cambio:' . $arrayShowCommits[4]);

        /* Pregunta Final de Confirmación */
        if ($this->confirm('¿Estas Seguro(a) De Ejecutar Una Reversion Al Cambio ' . $cambio . '?')) {

            // Ejecutar Reverso al Cambio
            ArtisanCommandClass::GitRevert($cambio);

            $this->info('Proceso Completo!');
            $this->line('End GitRevert Artisan Utilities');

        } else {

            $this->info('Proceso Cancelado!');
            $this->line('End GitRevert Artisan Utilities');

        }

    }
}
