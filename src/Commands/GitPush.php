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
    protected $description = 'Ejecutar Git Push al repositorio desde una rama puesta como parámetro, con la opción de ejecutar Pull de una Rama especifica creada en el repositorio.';

    /*
    |--------------------------------------------------------------------------
    | Incio Ejecución de Comando.
    |--------------------------------------------------------------------------
    |
    | Logaritmo Comando.
    |
    */
    public function handle(){

        $this->line('Start GitPush Artisan Utilities');

        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#
        #                       PARTE 1 - GIT STATUS                        #
        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#

        // Estatus del proyecto
        $this->info('Estado Actualización Proyecto...');
        $gitStatus = ArtisanCommandClass::GitStatus();
        $this->line($gitStatus);

        /* LLamado Comando Personalizado */
        $this->info('Haremos una limpieza del proyecto antes de cargarlo en GIT para garantizar que no se cargue información que puede generar conflicto con otra rama.');
        ArtisanCommandClass::CallArtisan('FlushCache');
        $this->info('Limpieza Completa y Exitosa!');

        /* Argumentos Funcion */
        $rama = $this->argument('rama');

        /* Si la rama enviada como argumento no existe, se detendra el proceso */
        if(!ArtisanCommandClass::branchValidate($rama)){
            return $this->error('La rama ingresada como parámetro no es la misma sobre la cual se está trabajando actualmente, por favor revise y vuelva a ejecutar el comando.');
        };

        $hora = date("Y-m-d H:i:s");

        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#
        #                       PARTE 2 - GIT ADD                           #
        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#

        /* GitAdd. */
        $this->info('Ejecutando...');
        $this->line('git add .');
        ArtisanCommandClass::GitAdd();
        ArtisanCommandClass::ProcessingTime(3);

        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#
        #                       PARTE 3 - GIT PULL                          #
        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#

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

            $preguntaPull = null;
            while ($preguntaPull == null) {

                $this->info('Este Proyecto Tiene Un Total De ' . $cantidadRamas . ' Rama(s) En GIT');

                $preguntaPull = $this->choice('Deseas Hacer Pull De Una Rama',[
                    'No', 'Si'
                ]);

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

        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#
        #                       PARTE 3 - GIT COMMIT                        #
        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#

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
                $this->info('El comentario asociado tiene menos de 2 caracteres, por lo cual no se usará en el Cambio a cargar, Registraremos el nombre del(los) archivo(s) modificado(s) de existir, de lo contrario la hora y fecha.');
                $this->info('Ejecutando...');

                /* Comentario */
                $comment = ArtisanCommandClass::comment($gitStatus);

                /* Git Commit */
                $this->line('git commit -m "' . $comment . '"');
                ArtisanCommandClass::GitCommit($comment);
                ArtisanCommandClass::ProcessingTime(3);
            }

        } else {

            ArtisanCommandClass::CallArtisan('FlushCache');

            /* De no haberse ingresado un comentario en el comando, se usará el datetime como comentario del commmit */
            $this->info('Registraremos el nombre del(los) archivo(s) modificado(s) de existir, de lo contrario la hora y fecha, en la ausencia de un comentario personalizado');
            $this->info('Ejecutando...');

            /* Comentario */
            $comment = ArtisanCommandClass::comment($gitStatus);

            /* Git Commit */
            $this->line('git commit -m "' . $comment . '"');
            ArtisanCommandClass::GitCommit($comment);
            ArtisanCommandClass::ProcessingTime(3);

        }

        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#
        #                       PARTE 3 - GIT PUSH                          #
        #▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬#

        $this->info('Ejecutando...');
        $this->line('git push origin ' . $this->argument('rama'));
        ArtisanCommandClass::GitPush($this->argument('rama'));
        ArtisanCommandClass::ProcessingTime(4);

        /* Mensaje de Confirmacion */
        $this->info('Proceso ejecutado con Exito!');

        /* Mensaje de Cierre */
        $this->line('End GitPush Artisan Utilities');

    }
}
