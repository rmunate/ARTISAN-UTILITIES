<?php

/*
|--------------------------------------------------------------------------
| Clase de Recursos | Comandos GIT
|--------------------------------------------------------------------------
|
| Definiciones Globales para los comandos personalizados de Artisan.
| Autor: Raul Mauricio Uñate Castro
| Fecha: 20-12-2021
|
*/

namespace App\Console;

use Artisan;
use Illuminate\Support\Facades\Storage;

class ArtisanCommandClass{

    /*
    |--------------------------------------------------------------------------
    | Metodos Estaticos Clase
    |--------------------------------------------------------------------------
    */

    # -- Validacion de Carpeta Storage (De no existir se crea el Dafault cumpliendo con todo el estandar actual.).
    public static function DeleteLogs(){

        # CARPETA PRINCIPAL

        /* Validacion Existencia Carpeta Storage */
        $path_storage = base_path() . '/storage';
        if (!file_exists($path_storage)) {
            mkdir($path_storage, 0777, true);
        }

        # SUB CARPETA APP

        /* Validacion Existencia Carpeta Storage/app */
        $path_storage_app = storage_path('app');
        if (!file_exists($path_storage_app)) {
            mkdir($path_storage_app, 0777, true);
        }

        /* Validacion Existencia archivo en caroeta Storage/app */
        $file_storage_app = storage_path('app/.gitignore');
        if (!file_exists($file_storage_app)) {
            $file_git_ignore1 = fopen($file_storage_app, 'w');
            fwrite($file_git_ignore1, "*" . PHP_EOL);
            fwrite($file_git_ignore1, "!public/" . PHP_EOL);
            fwrite($file_git_ignore1, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore1);
        }

        /* Validacion Existencia Carpeta Storage/app/public */
        $path_storage_app_public = storage_path('app/public');
        if (!file_exists($path_storage_app_public)) {
            mkdir($path_storage_app_public, 0777, true);
        }

        /* Validacion Existencia archivo en caroeta Storage/app/public */
        $file_storage_app_public = storage_path('app/public/.gitignore');
        if (!file_exists($file_storage_app_public)) {
            $file_git_ignore2 = fopen($file_storage_app_public, 'w');
            fwrite($file_git_ignore2, "*" . PHP_EOL);
            fwrite($file_git_ignore2, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore2);
        }

        # SUB CARPETA FRAMEWORK

        /* Validacion Existencia Carpeta Storage/framework */
        $path_storage_framework = storage_path('framework');
        if (!file_exists($path_storage_framework)) {
            mkdir($path_storage_framework, 0777, true);
        }

        /* Validacion Existencia archivo en carpeta Storage/framework/cache */
        $file_storage_framework_cache = storage_path('framework/.gitignore');
        if (!file_exists($file_storage_framework_cache)) {
            $file_git_ignore3 = fopen($file_storage_framework_cache, 'w');
            fwrite($file_git_ignore3, "compiled.php" . PHP_EOL);
            fwrite($file_git_ignore3, "config.php" . PHP_EOL);
            fwrite($file_git_ignore3, "down" . PHP_EOL);
            fwrite($file_git_ignore3, "events.scanned.php" . PHP_EOL);
            fwrite($file_git_ignore3, "maintenance.php" . PHP_EOL);
            fwrite($file_git_ignore3, "routes.php" . PHP_EOL);
            fwrite($file_git_ignore3, "routes.scanned.php" . PHP_EOL);
            fwrite($file_git_ignore3, "schedule-*" . PHP_EOL);
            fwrite($file_git_ignore3, "services.json" . PHP_EOL);
            fclose($file_git_ignore3);
        }

        /* Validacion Existencia Carpeta Storage/framework/cache */
        $path_storage_framework_cache = storage_path('framework/cache');
        if (!file_exists($path_storage_framework_cache)) {
            mkdir($path_storage_framework_cache, 0777, true);
        }

        /* Validacion Existencia archivo en carpeta Storage/framework/cache */
        $file_storage_framework_cache = storage_path('framework/cache/.gitignore');
        if (!file_exists($file_storage_framework_cache)) {
            $file_git_ignore4 = fopen($file_storage_framework_cache, 'w');
            fwrite($file_git_ignore4, "*" . PHP_EOL);
            fwrite($file_git_ignore4, "!data/" . PHP_EOL);
            fwrite($file_git_ignore4, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore4);
        }

        /* Validacion Existencia Carpeta Storage/framework/cache */
        $path_storage_framework_cache_data = storage_path('framework/cache/data');
        if (!file_exists($path_storage_framework_cache_data)) {
            mkdir($path_storage_framework_cache_data, 0777, true);
        }

        /* Validacion Existencia archivo en carpeta Storage/framework/cache */
        $file_storage_framework_cache_data = storage_path('framework/cache/data/.gitignore');
        if (!file_exists($file_storage_framework_cache_data)) {
            $file_git_ignore5 = fopen($file_storage_framework_cache_data, 'w');
            fwrite($file_git_ignore5, "*" . PHP_EOL);
            fwrite($file_git_ignore5, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore5);
        }

        /* Validacion Existencia Carpeta Storage/framework/sessions */
        $path_storage_framework_sessions = storage_path('framework/sessions');
        if (!file_exists($path_storage_framework_sessions)) {
            mkdir($path_storage_framework_sessions, 0777, true);
        }

        /* Validacion Existencia archivo en carpeta Storage/framework/sessions */
        $file_storage_framework_session = storage_path('framework/sessions/.gitignore');
        if (!file_exists($file_storage_framework_session)) {
            $file_git_ignore6 = fopen($file_storage_framework_session, 'w');
            fwrite($file_git_ignore6, "*" . PHP_EOL);
            fwrite($file_git_ignore6, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore6);
        }

        /* Validacion Existencia Carpeta Storage/framework/testing */
        $path_storage_framework_testing = storage_path('framework/testing');
        if (!file_exists($path_storage_framework_testing)) {
            mkdir($path_storage_framework_testing, 0777, true);
        }

        /* Validacion Existencia archivo en carpeta Storage/framework/testing */
        $file_storage_framework_testing = storage_path('framework/testing/.gitignore');
        if (!file_exists($file_storage_framework_testing)) {
            $file_git_ignore7 = fopen($file_storage_framework_testing, 'w');
            fwrite($file_git_ignore7, "*" . PHP_EOL);
            fwrite($file_git_ignore7, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore7);
        }

        /* Validacion Existencia Carpeta Storage/framework/views */
        $path_storage_framework_views = storage_path('framework/views');
        if (!file_exists($path_storage_framework_views)) {
            mkdir($path_storage_framework_views, 0777, true);
        }

        /* Validacion archivo en carpeta Storage/views */
        $file_storage_framework_views = storage_path('framework/views/.gitignore');
        if (!file_exists($file_storage_framework_views)) {
            $file_git_ignore8 = fopen($file_storage_framework_views, 'w');
            fwrite($file_git_ignore8, "*" . PHP_EOL);
            fwrite($file_git_ignore8, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore8);
        }

        # ELIMINACION Y CREACION LOGS

        /* Carpeta Logs */
        $path_storage_logs = storage_path('logs');
        if (!file_exists($path_storage_logs)) {
            mkdir($path_storage_logs, 0777, true);
        }

        /* Git Ignore Logs */
        $file_storage_logs = storage_path('logs/.gitignore');
        if (!file_exists($file_storage_logs)) {
            $file_git_ignore9 = fopen($file_storage_logs, 'w');
            fwrite($file_git_ignore9, "*" . PHP_EOL);
            fwrite($file_git_ignore9, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore9);
        }

        if (@unlink(storage_path('logs/laravel.log'))) {
            // Creacion Nuevo Archivo de Logs
            $file_handle = fopen(storage_path('logs/laravel.log'), 'w');
            fclose($file_handle);
        }

    }

    # -- Llamados Artisan
    public static function CallArtisan($comando){

        $artisan = [
            /* Llamados a Metodos Originales */
            'cache'         =>  'cache:clear',
            'config'        =>  'config:clear',
            'view'          =>  'view:clear',
            'route'         =>  'route:clear',
            'auth'          =>  'auth:clear-resets',
            'optimize'      =>  'optimize:clear',
            'event'         =>  'event:clear',
            'permission'    =>  'permission:cache-reset',
            'queue'         =>  'queue:flush',
            'schedule'      =>  'schedule:clear-cache',
            /* Llamados a Metodos Propios */
            'FlushCache'    =>  'FlushCache',
        ];

        return  Artisan::call($artisan[$comando]);
    }

    # -- Ejecuaciones de comandos Shell
    public static function GitStatus(){
        /* Retorna las lineas de GitStatus */
        $status = shell_exec('git status');

        /* Limpiar Respuesta */
        // Convertir en Array
        $status = explode("\n", $status);

        /* Eliminar Lineas Con informacion no relevante a cambios vigentes. */
        for ($i=0; $i <= 5; $i++) {
            if(isset($status[$i])){
                unset($status[$i]);
            }
        }

        /* Eliminar Filas Vacias*/
        $data = [];
        if (count($status) > 0) {
            foreach ($status as $one) {
                if (($one != "") && (!str_contains($one, 'no changes added')) && (!str_contains($one, 'Changes not staged')) && (!str_contains($one, 'git add')) && (!str_contains($one, 'git restore'))) {
                    $one = str_replace("\t", "", $one);
                    $one = str_replace(":   ", " => ", $one);
                    array_push($data, $one);
                }
            }
        } else {
            array_push($data, 'No Registran Cambios Locales');
        }

        return $data;
    }

    # -- Ejecuaciones de comandos Shell
    public static function GitAdd(){
        /* Agregar Todos los Cambios Locales */
        $add = shell_exec('git add .');
        return $add;
    }

    // Tiempo de Proceso
    public static function ProcessingTime($time){
        sleep($time);
    }

    # -- Comentario Archivos Modificados
    public static function comment($array){

        if(count($array) > 0 && $array[0] != 'No Registran Cambios Locales'){
            $data = [];
            foreach ($array as $key => $value) {
                $linea = explode(' => ', $value);
                $linea = $linea[count($linea) - 1];
                array_push($data, $linea);
            }
            $data = implode(', ', $data);
            return 'Archivo(s) Actualizado(s) => ' . $data;

        } else {
            return 'Cambios => ' . date('Y-m-d H:i:s');
        }

    }

    # -- Validar Rama Enviada Como Parametro
    public static function branchValidate($rama){

        /* Consultar Ramas */
        $ramasCrudo = Self::GitBranch();

        /* Arreglo con las Ramas */
        $arrayRamas = explode('remotes/origin/' , $ramasCrudo);
        $ramasFinal = Self::ArrayRamas($arrayRamas);

        foreach ($ramasFinal as $key => $value) {
            if ($value == $rama) {
                return true;
            } else {
                return false;
            }
        }
    }

    # -- Ejecuaciones de comandos Shell
    public static function GitCommit($comentarioCommit){

        $commit = shell_exec('git commit -m "' . $comentarioCommit . '"');
        return $commit;
    }

    # -- Ejecuaciones de comandos Shell
    public static function GitBranch(){

        $branch = shell_exec('git branch -a');
        return $branch;
    }

    # -- Tratamiento de ArraysRamas
    public static function ArrayRamas($arrayRamas){

        $ramasStrLen = [];
        foreach ($arrayRamas as $rama) {
            array_push($ramasStrLen,$rama);
        }

        $ramasPreFilter = [];
        foreach ($ramasStrLen as $rama) {
            // Reglas para Remplazar
            $search  = array("* ", "\n  master\n  ", "HEAD -> origin/master\n  ", "\n  main\n  ", "HEAD -> origin/main\n  ", "\n  ","\n");
            $replace = array('');
            $subject = str_replace($search, $replace, $rama);
            array_push($ramasPreFilter,$subject);
        }

        $ramasFinal = [];
        foreach ($ramasPreFilter as $rama) {
            // Reglas para Arreglo Final
            if ($rama !== '') {
                if (!in_array($rama, $ramasFinal)) {
                    array_push($ramasFinal,$rama);
                }
            }
        }

        return $ramasFinal;
    }

    # -- Ejecuaciones de comandos Shell
    public static function GitPull($pullRama){

        $pull = shell_exec('git pull origin '. $pullRama);
        return $pull;
    }

    # -- Ejecuaciones de comandos Shell
    public static function GitPush($rama){

        $push = shell_exec('git push origin ' . $rama);
        return $push;
    }

    # -- Comando Git para comocer los Logs del Sistema
    public static function GitCommits(){

        $commits = (shell_exec('git log --oneline'));
        $arrayCommits = explode("\n" , $commits);
        return $arrayCommits;

    }

    # -- Comandos Git para sanear el arreglo de Commits Log
    public static function GitLogs($arrayCommits_t){

        // Recorriendo Array para sanear el [\t]
        $arrayCommitsList = [];
        foreach ($arrayCommits_t as $commit) {

            $search  = "\t";
            $replace = "";
            $ajuste =  str_replace($search, $replace, $commit);

            array_push($arrayCommitsList, $ajuste);

        }

        return $arrayCommitsList;
    }

    # -- Comando para hacer el show del cambio a ejecutar
    public static function GitShow($cambio){

        // Conocer el autor y fecha de carga.
        $showCommit = (shell_exec('git show '. $cambio));

        // Generando un array de los commits
        $arrayShowCommits = explode("\n" , $showCommit);

        return $arrayShowCommits;
    }

    # -- Comando para hacer el Revert
    public static function GitRevert($cambio){

        // Ejecutar Reverso al Cambio
        $revert = shell_exec('git revert '. $cambio);

        return $revert;
    }

    # -- Comando para hacer el reset
    public static function GitReset($cambio){

        // Ejecutar Reverso al Cambio
        $reset = shell_exec('git reset --hard '. $cambio);

        return $reset;
    }


}

?>
