<?php

namespace App\Console;

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Comandos Personalizados Artisan
|--------------------------------------------------------------------------
| Clase de metodos estaticos para la ejecucion de los comenados externos.
| Autor: Raul Mauricio Uñate Castro
| V 1.0: 20-12-2021
| V 1.2: 01-05-2022
| V 2.0: 19-07-2022 (Reescrito)
|--------------------------------------------------------------------------
|
*/

class ArtisanUtilities {

    /**
     * Lineas de Inicio y Cierre Comando Artisan
     * @var string
     */
    public static $start = 'Start FlushCache Artisan Utilities';
    public static $last = 'Proceso ejecutado con Exito!';
    public static $end = 'End FlushCache Artisan Utilities';
    public static $cancel = 'Proceso Cancelado!';

    /**
     * Comandos Git
     * @var string
     */
    private static $gitStatus = 'git status';
    private static $gitAdd = 'git add .';
    private static $gitCommit = 'git commit -m';
    private static $gitBranch = 'git branch -a';
    private static $gitPull = 'git pull origin';
    private static $gitPush = 'git push origin';
    private static $gitLog = 'git log --oneline';
    private static $gitShow = 'git show';
    private static $gitRevert = 'git revert';
    private static $gitReset = 'git reset';

    /**
     * Mensajes que se retornan al ejecutar Git Add sin encontrar o encontrando cambios locales
     * @var string
     */
    private static $noChangesRecorded = 'No Registran Cambios Desde La Última Publicación';
    private static $commentChangesFiles = 'Archivo(s) Actualizado(s)';
    private static $commentNoChangesFiles = 'Actualización Sin Cambios En Rama.';

    /**
     * Eliminacion Recursiva Carpeta
     * @method
     * @return Void
     */
    public static function rrmdir(string $src) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $src . '/' . $file;
                if (is_dir($full) ) {
                    Self::rrmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }

    /**
     * Eliminacion y creacion de la carpeta Storage,
     * Compatible con versiones 8^
     * @method
     * @return Void
     */
    public static function DefaultStorage(){

        #1. CARPETA PRINCIPAL.
        $path_storage = base_path() . '/storage';
        if (!file_exists($path_storage)) {
            mkdir($path_storage, 0777, true);
        } else {
            Self::rrmdir($path_storage);
            mkdir($path_storage, 0777, true);
        }

        #2. SUBCARPETA APP
        $path_storage_app = storage_path('app');
        if (!file_exists($path_storage_app)) {
            mkdir($path_storage_app, 0777, true);
        }

        #2.1. GitIgnore Carpeta.
        $file_storage_app = storage_path('app/.gitignore');
        if (!file_exists($file_storage_app)) {
            $gitignore = fopen($file_storage_app, 'w');
            fwrite($gitignore, "*" . PHP_EOL);
            fwrite($gitignore, "!public/" . PHP_EOL);
            fwrite($gitignore, "!.gitignore" . PHP_EOL);
            fclose($gitignore);
        }

        #2.2 Validacion Existencia Carpeta Storage/app/public
        $path_storage_app_public = storage_path('app/public');
        if (!file_exists($path_storage_app_public)) {
            mkdir($path_storage_app_public, 0777, true);
        }

        #2.2.1 Validacion Existencia archivo en carpeta Storage/app/public
        $file_storage_app_public = storage_path('app/public/.gitignore');
        if (!file_exists($file_storage_app_public)) {
            $gitignore = fopen($file_storage_app_public, 'w');
            fwrite($gitignore, "*" . PHP_EOL);
            fwrite($gitignore, "!.gitignore" . PHP_EOL);
            fclose($gitignore);
        }

        #3. SUB CARPETA FRAMEWORK | Validacion Existencia Carpeta Storage/framework
        $path_storage_framework = storage_path('framework');
        if (!file_exists($path_storage_framework)) {
            mkdir($path_storage_framework, 0777, true);
        }

        #3.1 Validacion Existencia archivo en carpeta Storage/framework/cache
        $file_storage_framework_cache = storage_path('framework/.gitignore');
        if (!file_exists($file_storage_framework_cache)) {
            $gitignore = fopen($file_storage_framework_cache, 'w');
            /* Configuración por defecto. */
            fwrite($gitignore, "*" . PHP_EOL);
            fwrite($gitignore, "!cache/" . PHP_EOL);
            fwrite($gitignore, "!sessions/" . PHP_EOL);
            fwrite($gitignore, "!testing/" . PHP_EOL);
            fwrite($gitignore, "!views/" . PHP_EOL);
            fwrite($gitignore, "!.gitignore" . PHP_EOL);
            /* Configuración Escrituras Adicionales */
            fwrite($gitignore, "compiled.php" . PHP_EOL);
            fwrite($gitignore, "config.php" . PHP_EOL);
            fwrite($gitignore, "down" . PHP_EOL);
            fwrite($gitignore, "events.scanned.php" . PHP_EOL);
            fwrite($gitignore, "maintenance.php" . PHP_EOL);
            fwrite($gitignore, "routes.php" . PHP_EOL);
            fwrite($gitignore, "routes.scanned.php" . PHP_EOL);
            fwrite($gitignore, "schedule-*" . PHP_EOL);
            fwrite($gitignore, "services.json" . PHP_EOL);
            fclose($gitignore);
        }

        #3.2 Validacion Existencia Carpeta Storage/framework/cache
        $path_storage_framework_cache = storage_path('framework/cache');
        if (!file_exists($path_storage_framework_cache)) {
            mkdir($path_storage_framework_cache, 0777, true);
        }

        #3.3. Validacion Existencia archivo en carpeta Storage/framework/cache
        $file_storage_framework_cache = storage_path('framework/cache/.gitignore');
        if (!file_exists($file_storage_framework_cache)) {
            $file_git_ignore4 = fopen($file_storage_framework_cache, 'w');
            fwrite($file_git_ignore4, "*" . PHP_EOL);
            fwrite($file_git_ignore4, "!data/" . PHP_EOL);
            fwrite($file_git_ignore4, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore4);
        }

        #3.4. Validacion Existencia Carpeta Storage/framework/cache/data
        $path_storage_framework_cache_data = storage_path('framework/cache/data');
        if (!file_exists($path_storage_framework_cache_data)) {
            mkdir($path_storage_framework_cache_data, 0777, true);
        }

        #3.5 Validacion Existencia archivo en carpeta Storage/framework/cache
        $file_storage_framework_cache_data = storage_path('framework/cache/data/.gitignore');
        if (!file_exists($file_storage_framework_cache_data)) {
            $file_git_ignore5 = fopen($file_storage_framework_cache_data, 'w');
            fwrite($file_git_ignore5, "*" . PHP_EOL);
            fwrite($file_git_ignore5, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore5);
        }

        #3.6 Validacion Existencia Carpeta Storage/framework/sessions
        $path_storage_framework_sessions = storage_path('framework/sessions');
        if (!file_exists($path_storage_framework_sessions)) {
            mkdir($path_storage_framework_sessions, 0777, true);
        }

        #3.7 Validacion Existencia archivo en carpeta Storage/framework/sessions
        $file_storage_framework_session = storage_path('framework/sessions/.gitignore');
        if (!file_exists($file_storage_framework_session)) {
            $file_git_ignore6 = fopen($file_storage_framework_session, 'w');
            fwrite($file_git_ignore6, "*" . PHP_EOL);
            fwrite($file_git_ignore6, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore6);
        }

        #3.8 Validacion Existencia Carpeta Storage/framework/testing
        $path_storage_framework_testing = storage_path('framework/testing');
        if (!file_exists($path_storage_framework_testing)) {
            mkdir($path_storage_framework_testing, 0777, true);
        }

        #3.9 Validacion Existencia archivo en carpeta Storage/framework/testing
        $file_storage_framework_testing = storage_path('framework/testing/.gitignore');
        if (!file_exists($file_storage_framework_testing)) {
            $file_git_ignore7 = fopen($file_storage_framework_testing, 'w');
            fwrite($file_git_ignore7, "*" . PHP_EOL);
            fwrite($file_git_ignore7, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore7);
        }

        #3.10 Validacion Existencia Carpeta Storage/framework/views
        $path_storage_framework_views = storage_path('framework/views');
        if (!file_exists($path_storage_framework_views)) {
            mkdir($path_storage_framework_views, 0777, true);
        }

        #3.11 Validacion archivo en carpeta Storage/views */
        $file_storage_framework_views = storage_path('framework/views/.gitignore');
        if (!file_exists($file_storage_framework_views)) {
            $file_git_ignore8 = fopen($file_storage_framework_views, 'w');
            fwrite($file_git_ignore8, "*" . PHP_EOL);
            fwrite($file_git_ignore8, "!.gitignore" . PHP_EOL);
            fclose($file_git_ignore8);
        }

        #4 ELIMINACION Y CREACION LOGS

        #4.1 Creacion Carpeta de Logs
        $path_storage_logs = storage_path('logs');
        if (!file_exists($path_storage_logs)) {
            mkdir($path_storage_logs, 0777, true);
        }

        #4.2 Git Ignore Logs
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

        /* Permisos CHMOD */
        chmod(storage_path('logs'), 777);
        chmod(storage_path('framework/views'), 777);
        chmod(storage_path('framework/testing'), 777);
        chmod(storage_path('framework/sessions'), 777);
        chmod(storage_path('framework/cache/data'), 777);
        chmod(storage_path('framework/cache'), 777);
        chmod(storage_path('framework'), 777);
        chmod(storage_path('app/public'), 777);
        chmod(storage_path('app'), 777);
        chmod(base_path() . '/storage', 777);
        chmod(base_path() . '/public', 777);

    }

    /**
     * Llamado Comandos Artisan
     * @method
     * @return Command
     */
    public static function Call(string $comando){

        $artisan = [
            /* Llamados a Metodos Originales */
            'cache' => 'cache:clear',
            'config' => 'config:clear',
            'view' => 'view:clear',
            'route' => 'route:clear',
            'auth' => 'auth:clear-resets',
            'optimize' => 'optimize:clear',
            'event' => 'event:clear',
            'permission' => 'permission:cache-reset',
            'queue' => 'queue:flush',
            'schedule' => 'schedule:clear-cache',
            /* Llamados a Metodos Propios */
            'FlushCache' => 'FlushCache'
        ];

        if (isset($artisan[$comando])) {
            return  Artisan::call($artisan[$comando]);
        } else {
            return  Artisan::call($comando);
        }

    }

    /**
     * Ejecuta GitStatus y retorna las modificaciones en un arreglo limpio
     * @method
     * @return array
     */
    public static function GitStatus(){

        /* Retorna las lineas de GitStatus */
        $status = shell_exec(Self::$gitStatus);

        /* Convertir en arreglo */
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
                if ( ($one != "") && (!str_contains($one, 'no changes added')) && (!str_contains($one, 'Changes not staged')) && (!str_contains($one, 'git add')) && (!str_contains($one, 'git restore'))) {
                    $one = str_replace("\t", "", $one);
                    $one = str_replace(":   ", " => ", $one);
                    array_push($data, $one);
                }
            }
        } else {
            array_push($data, Self::$noChangesRecorded);
        }

        return $data;
    }

    /**
     * Ejecuta git add .
     * @method
     * @return string
     */
    public static function GitAdd(){
        /* Agregar Todos los Cambios Locales */
        $add = shell_exec(Self::$gitAdd);
        return $add;
    }

    /**
     * Congela el proceso por los segundos ingresados.
     * @method
     * @param int $time
     * @return Void
     */
    public static function ProcessingTime(int $time){
        sleep($time);
    }

    /**
     * Retorna el comentario del Commit
     * @method
     * @param array $array
     * @return String
     */
    public static function comment(array $array){

        if(count($array) > 0 && $array[0] != Self::$noChangesRecorded){
            $data = [];
            foreach ($array as $key => $value) {
                $linea = explode(' => ', $value);
                $linea = $linea[count($linea) - 1];
                array_push($data, $linea);
            }
            $data = implode(', ', $data);
            return Self::$commentChangesFiles . ' => ' . $data;
        } else {
            return Self::$commentNoChangesFiles . ' ' . date('Y-m-d H:i:s');
        }

    }

    /**
     * Validacion de la Rama en Uso para no cargar en ramas erradas.
     * @method
     * @param string $rama
     * @return Bool
     */
    public static function branchValidate(string $rama){

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

    /**
     * Ejecuta el Git Commit con el comentario correspondiente.
     * @method
     * @param string $comentarioCommit
     * @return String
     */
    public static function GitCommit(string $comentarioCommit){
        $commit = shell_exec(Self::$gitCommit . ' "' . $comentarioCommit . '"');
        return $commit;
    }

    /**
     * Ejecucion del gitBranch
     * @method
     * @return String
     */
    public static function GitBranch(){
        $branch = shell_exec(Self::$gitBranch);
        return $branch;
    }

    /**
     * Limpia las ramas del proyecto y retorna un arreglo con ellas
     * @method
     * @param array $arrayRamas
     * @return array
     */
    public static function ArrayRamas(array $arrayRamas){

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

        $ramasFinal = array_unique($ramasFinal);

        return $ramasFinal;
    }

    /**
     * Ejecuta el git pull de la rama especificada por parametro
     * @method
     * @param string $pullRama
     * @return String
     */
    public static function GitPull(string $pullRama){
        $pull = shell_exec(Self::$gitPull . ' ' . $pullRama);
        return $pull;
    }

    /**
     * Ejecuta el comando de Git Push desde una rama especifica
     * @method
     * @param string $rama
     * @return String
     */
    public static function GitPush(string $rama){
        $push = shell_exec(Self::$gitPush . ' ' . $rama);
        return $push;
    }

    /**
     * Retorna un arreglo con todos los commits cargados del proyecto.
     * @method
     * @return Array
     */
    public static function GitCommits(){
        $commits = (shell_exec(Self::$gitLog));
        $arrayCommits = explode("\n" , $commits);
        $arrayCommits = array_unique($arrayCommits);
        return $arrayCommits;

    }

    /**
     * Saniamiento de los Log del GitCommits()
     * @method
     * @param array $arrayCommits_t
     * @return Array
     */
    public static function GitLogs(array $arrayCommits_t){
        // Recorriendo Array para sanear el [\t]
        $arrayCommitsList = [];
        foreach ($arrayCommits_t as $commit) {
            $search  = "\t";
            $replace = "";
            $ajuste =  str_replace($search, $replace, $commit);
            array_push($arrayCommitsList, $ajuste);
        }
        $arrayCommitsList = array_unique($arrayCommitsList);
        return $arrayCommitsList;
    }

    /**
     * Retorna el Git Show del Cambio ingresado
     * @method
     * @param string $cambio
     * @return String
     */
    public static function GitShow(string $cambio){
        // Conocer el autor y fecha de carga.
        $showCommit = (shell_exec(Self::$gitShow . ' '. $cambio));
        // Generando un array de los commits
        $arrayShowCommits = explode("\n" , $showCommit);
        return $arrayShowCommits;
    }

    /**
     * Ejecuta el Gir Revert
     * @method
     * @param string $cambio
     * @return String
     */
    public static function GitRevert(string $cambio){
        $revert = shell_exec(Self::$gitRevert . ' '. $cambio);
        return $revert;
    }

    /**
     * Ejecuta un Reset hasta un cambio especificado
     * @method
     * @param string $cambio
     * @return String
     */
    public static function GitReset(string $cambio){
        $reset = shell_exec(Self::$gitReset . ' --hard '. $cambio);
        return $reset;
    }

    /**
     * Ocultar Los Errores de PHP
     * @return Void
     */
    public static function errorHidden(){
        return error_reporting(0);
    }

    /**
     * Mostrar Los Errores de PHP
     * @return Void
     */
    public static function errorShow(){
        return error_reporting(-1);
    }

}


?>
