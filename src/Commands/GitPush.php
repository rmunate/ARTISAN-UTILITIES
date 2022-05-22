<?php

/*
|--------------------------------------------------------------------------
| Comando para Ejecutar GitPush
|--------------------------------------------------------------------------
|
| Este comando simplifica la ejecucion de los comandos Git para la carga de datos al repositorio.
| Adicional permite seleccionar si se desea hacer pull de alguna Rama.
| Autor: Raul Mauricio Uñate Castro
| Fecha: 20-12-2021
|
*/

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use App\Console\ArtisanCommandClass;

class GitPush extends Command{
    /*
    |--------------------------------------------------------------------------
    | Identificación Comando.
    |--------------------------------------------------------------------------
    |
    | $signature = Nombre para Consola.
    | description = Descripción.
    |
    */
    protected $signature = 'GitPush {rama} {--m=}';
    protected $description = 'Ejecutar Git Push al repositorio con la opción de ejecutar pull de una Rama especifica creada en el repositorio.';

    /*
    |--------------------------------------------------------------------------
    | Incio Ejecución de Comando.
    |--------------------------------------------------------------------------
    |
    | Logaritmo Comando.
    |
    */
    public function handle(){

        $this->line('Start GitPush Artisan Utilites');

        // Estatus del proyecto
        $this->info('Estado Actualización Proyecto...');
        $this->line(ArtisanCommandClass::GitStatus());

        /* LLamado Comando Personalizado */
        $this->info('Haremos una limpieza de su proyecto antes de cargarlo en GIT para garantizar que no se cargue información que puede generar conflicto con otra rama.');
        ArtisanCommandClass::CallArtisan('FlushCache');
        $this->info('Limpieza Completa y Exitosa!');

        /* Argumentos Funcion */
        $rama = $this->argument('rama');
        $hora = date("Y-m-d H:i:s");

        /* GitAdd. */
        $this->info('Ejecutando...');
        $this->line('git add .');
        ArtisanCommandClass::GitAdd();
        ArtisanCommandClass::ProcessingTime(3);

        // Definir si existe comentarios para el Commit
        if (is_string($this->option()["m"])) {

            /* Se Valida la longitud de la Observacion. */
            if (strlen($this->option()["m"]) > 2) {

                ArtisanCommandClass::CallArtisan('FlushCache');

                /* De tener mas de dos Caracteres, se usará el texto como comentario del commmit */
                $comentarioCommit = $this->option()["m"];
                $this->info('Ejecutando...');
                $this->line('git commit -m "' . $comentarioCommit . '"');
                ArtisanCommandClass::GitCommit($comentarioCommit);
                ArtisanCommandClass::ProcessingTime(3);

            } else {

                ArtisanCommandClass::CallArtisan('FlushCache');

                /* De tener menos de 2 caracteres, se usará el datatime como comentario del commmit */
                $this->info('El comentario asociado tiene menos de 2 caracteres, por lo cual no se usará en el Cambio a cargar, usaremos la fecha y hora actual.');
                $this->info('Ejecutando...');
                $this->line('git commit -m "Update ' . $hora . '"');
                ArtisanCommandClass::GitCommit($hora);
                ArtisanCommandClass::ProcessingTime(3);

            }

        } else {

            ArtisanCommandClass::CallArtisan('FlushCache');

            /* De no haberse ingresado un comentario en el comando, se usará el datetime como comentario del commmit */
            $this->info('Se usará la hora y fecha como comentario del Cambio, en la ausencia de un comentario personalizado');
            $this->info('Ejecutando...');
            $this->line('git commit -m "Update ' . $hora . '"');
            ArtisanCommandClass::GitCommit($hora);
            ArtisanCommandClass::ProcessingTime(3);

        }

        /* Ramas Proyecto | Conocer las Ramas Asociadas al Proyecto. */
        $ramas = ArtisanCommandClass::GitBranch();

        /* Generando un array de las ramas. */
        $arrayRamas = explode('remotes/origin/' , $ramas);

        /* De contar con dos ramas o más. */
        if (count($arrayRamas) > 1) {

            /* Arreglo con las Ramas */
            $ramasFinal = ArtisanCommandClass::ArrayRamas($arrayRamas);

            /* Cantidad de Ramas */
            $cantidadRamas = count($ramasFinal);

            $preguntaPull = 'undefined';
            while ($preguntaPull <> 'No') {

                $this->info('Este Proyecto Tiene Un Total De ' . $cantidadRamas . ' Rama(s) En GIT');

                $preguntaPull = $this->choice(
                    'Deseas Hacer Pull De Una Rama',
                    ['No', 'Si']
                );

                if ($preguntaPull == 'Si') {

                    $pullRama = $this->choice(
                        'Selecciona La Rama Desde La Cual Ejecutar El Pull',
                        $ramasFinal
                    );

                    ArtisanCommandClass::CallArtisan('FlushCache');

                    $this->info('Ejecutando...');
                    $this->line('git pull origin ' . $pullRama);
                    ArtisanCommandClass::GitPull($pullRama);
                    ArtisanCommandClass::ProcessingTime(4);

                }
            }
        }

        ArtisanCommandClass::CallArtisan('FlushCache');

        $this->info('Ejecutando...');
        $this->line('git push origin ' . $this->argument('rama'));
        ArtisanCommandClass::GitPush($this->argument('rama'));
        ArtisanCommandClass::ProcessingTime(4);

        /* Mensaje de Confirmacion */
        $this->info('Proceso ejecutado con Exito!');

        /* Mensaje de Cierre */
        $this->line('End GitPush Artisan Utilites');

    }
}
