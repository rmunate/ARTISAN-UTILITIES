<?php

/*
|--------------------------------------------------------------------------
| Comando para Ejecutar GitPush
|--------------------------------------------------------------------------
|
| Este comando simplifica la ejecucion de los comandos Git para la carga de datos al repositorio.
| Adicional permite seleccionar si se desea hacer pull de alguna Rama.
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

class GitPush extends Command {

    /**
     * Nombre del Comando
     * @var string
     */
    protected $signature = 'GitPush {rama} {--m=}';

    /**
     * Descripcion del proyecto
     * @var string
     */
    protected $description = 'Ejecutar Git Push al repositorio desde una rama puesta como parámetro, con la opción de ejecutar Pull de una Rama especifica creada en el repositorio.';

    /**
     * Mensaje que se retorna si la rama enviada como parametro no es la misma que esta en uso.
     * @var string
     */
    private $msgErrorRama = 'La Rama Ingresada Como Parámetro No Es La Misma Sobre La Cual Se Está Trabajando, Por Favor Revise Y Vuelva A Ejecutar El Comando.';

    /**
     * Mensaje en los casos donde el comentario personalizado es inferior a 2 caracteres.
     * @var string
     */
    private $msgComentarioInvalido = 'El comentario asociado tiene menos de 2 caracteres, por lo cual no se usará en el Cambio a cargar, Registraremos el nombre del(los) archivo(s) modificado(s) de existir, de lo contrario la hora y fecha.';

    /**
     * Comentario en pantalla en los casos donde no se ingrese un comentario personalizado.
     * @var string
     */
    private $commentDefault = 'Registraremos el nombre del(los) archivo(s) modificado(s) de existir, de lo contrario la hora y fecha, en la ausencia de un comentario personalizado';

    /**
     * Mensaje de Pregunta si desea hacer pull
     * @var string
     */
    private $msgConfirmPull = 'Deseas Hacer Pull De Una Rama';

    /**
     * Mensaje previo a seleccionar la rama.
     * @var string
     */
    private $selectRama = 'Selecciona La Rama Desde La Cual Ejecutar El Pull';

    /**
     * Codigo del Comando
     * @return Void
     */
    public function handle(){

        /* Inicio Comando */
        $this->line(ArtisanUtilities::$start);

        /* Argumentos Funcion */
        $rama = $this->argument('rama');

        /* Si la rama enviada como argumento no es la misma en uso, se detendra el proceso */
        if(!ArtisanUtilities::branchValidate($rama)){
            return $this->error($this->msgErrorRama);
        };

        /* Estatus del proyecto */
        $this->info('Leyendo Archivos Modificados En El Proyecto...');
        $gitStatus = ArtisanUtilities::GitStatus();
        $this->line($gitStatus);

        /* LLamado Comando FlushCache */
        $this->info('Ejecutando Limpieza Del Proyecto Previo A Cargarlo En GIT.');
        ArtisanUtilities::Call('FlushCache');

        /* GIT ADD . */
        $this->info('Ejecutando...');
        $this->line('git add .');
        ArtisanUtilities::GitAdd();
        ArtisanUtilities::ProcessingTime(3);

        /* GIT COMMIT */
        /* Definir si existe comentarios para el Commit */
        if (is_string($this->option()["m"])) {

            /* Se Valida la longitud de la Observacion. */
            if (strlen($this->option()["m"]) > 2) {

                /* LLamado Comando FlushCache */
                ArtisanUtilities::Call('FlushCache');

                /* De tener mas de dos Caracteres, se usará el texto como comentario del commmit */
                $comentarioCommit = $this->option()["m"];
                $this->info('Ejecutando...');
                $this->line('git commit -m "' . $comentarioCommit . '"');
                ArtisanUtilities::GitCommit($comentarioCommit);
                ArtisanUtilities::ProcessingTime(3);

            } else {

                /* LLamado Comando FlushCache */
                ArtisanUtilities::Call('FlushCache');

                /* De tener menos de 2 caracteres, se usará el datatime como comentario del commmit */
                $this->info($this->msgComentarioInvalido);

                /* Comentario */
                $comment = ArtisanUtilities::comment($gitStatus);

                /* Git Commit */
                $this->info('Ejecutando...');
                $this->line('git commit -m "' . $comment . '"');
                ArtisanUtilities::GitCommit($comment);
                ArtisanUtilities::ProcessingTime(3);
            }

        } else {

            /* LLamado Comando FlushCache */
            ArtisanUtilities::Call('FlushCache');

            /* De no haberse ingresado un comentario en el comando, se usará el datetime como comentario del commmit */
            $this->info($this->commentDefault);

            /* Comentario */
            $comment = ArtisanUtilities::comment($gitStatus);

            /* Git Commit */
            $this->info('Ejecutando...');
            $this->line('git commit -m "' . $comment . '"');
            ArtisanUtilities::GitCommit($comment);
            ArtisanUtilities::ProcessingTime(3);

        }

        /* GIT PULL */
        /* Ramas Proyecto | Conocer las Ramas Asociadas al Proyecto. */
        $ramas = ArtisanUtilities::GitBranch();

        /* Generando un array de las ramas. */
        $arrayRamas = explode('remotes/origin/' , $ramas);

        /* De contar con dos ramas o más. */
        if (count($arrayRamas) > 1) {

            /* Arreglo con las Ramas */
            $ramasFinal = ArtisanUtilities::ArrayRamas($arrayRamas);

            /* Cantidad de Ramas */
            $cantidadRamas = count($ramasFinal);

            $preguntaPull = null;
            while ($preguntaPull == null) {

                $this->info('Este Proyecto Tiene Un Total De ' . $cantidadRamas . ' Rama(s) En GIT');

                $preguntaPull = $this->choice($this->msgConfirmPull,['No', 'Si']);

                if ($preguntaPull == 'Si') {

                    $pullRama = $this->choice($this->selectRama,$ramasFinal);

                    /* LLamado Comando FlushCache */
                    ArtisanUtilities::Call('FlushCache');

                    /* Git Pull */
                    $this->info('Ejecutando...');
                    $this->line('git pull origin ' . $pullRama);
                    ArtisanUtilities::GitPull($pullRama);
                    ArtisanUtilities::ProcessingTime(4);

                    /* Git Add */
                    ArtisanUtilities::GitAdd();
                    ArtisanUtilities::ProcessingTime(3);

                    /* Comentario */
                    $comment = 'Pull Desde El Origen =>' . $pullRama;

                    /* Git Commit */
                    $this->info('Ejecutando...');
                    $this->line('git commit -m "' . $comment . '"');
                    ArtisanUtilities::GitCommit($comment);
                    ArtisanUtilities::ProcessingTime(3);

                }
            }
        }

        /* LLamado Comando FlushCache */
        ArtisanUtilities::Call('FlushCache');

        /* GIT PUSH */
        $this->info('Ejecutando...');
        $this->line('git push origin ' . $rama);
        ArtisanUtilities::GitPush($rama);
        ArtisanUtilities::ProcessingTime(4);

        /* Cierre */
        $this->info(ArtisanUtilities::$last);
        $this->line(ArtisanUtilities::$end);

    }
}
