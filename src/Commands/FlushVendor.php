<?php

/*
|--------------------------------------------------------------------------
| Remplazo Automatizado de Archivos en Vendor
|--------------------------------------------------------------------------
|
| Este comando simplifica el remplazar archivos en Vendor para que no se pierdan ajustes.
| Autor: Raul Mauricio Uñate Castro
| Fecha: 20-12-2021
|
*/

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use App\Console\ArtisanCommandClass;

class FlushVendor extends Command
{
    /*
    |--------------------------------------------------------------------------
    | Identificación Comando.
    |--------------------------------------------------------------------------
    |
    | $signature = Nombre para Consola.
    | description = Descripción.
    |
    */
    protected $signature = 'FlushVendor';
    protected $description = 'Remplaza archivos y directorios del Vendor, esto pensado en las modificaciones que suelen ejecutarse en esta carpeta y que se pierden en los Updates.';

    /*
    |--------------------------------------------------------------------------
    | Incio Ejecución de Comando.
    |--------------------------------------------------------------------------
    |
    | Logaritmo Comando.
    |
    */
    public function handle(){

        /* Titulo Libreria */
        $this->line('Start FlushVendor Artisan Utilities');

        /* Inicio de Ejecucion */
        $this->info('Inicio Lectura Fichero De Rutas');
        require ('FlushVendor/Routes.php');

        /* Proceso para archivos */
        $this->line('');
        $this->line('----- :::  ARCHIVOS  ::: -----');

        /* Validacion Cantidad de Archivos de Origen */
        $cantArch = count($routeFile['origen']);
        $this->info('Cantidad De Archivos Listados ' . $cantArch);

        if ($cantArch > 0) {

            $cantDesti = count($routeFile['destino']);
            $this->info('Cantidad De Rutas Destino Listadas ' . $cantDesti);

            if ($cantArch == $cantDesti) {

                $this->info('Inicio Ejecucion De Remplazos');

                /* Inicio de los Remplazos de los Ficheros */
                $eventosArchivos = [];
                for ($i = 0; $i < $cantArch; $i++) {

                    /* Validacion de Archivo en Destino */
                    if (is_file('vendor/' . $routeFile['destino'][$i])) {
                        $eventosArchivos[$i]['Validacion'] = ('Archvio [ ' . $routeFile['origen'][$i] . ' ], Encontrado En La Ruta De Destino.');

                    } else {
                        $eventosArchivos[$i]['Validacion'] =('En La Ruta Destino, No Existe Un Archivo Con El Nombre [ ' . $routeFile['origen'][$i] . ' ], Por Lo Cual Se Copiara Sin Afectar Ningun Fichero.');
                    }

                    /* Copia de Archivo */
                    if(copy('app/Console/Commands/FlushVendor/Files/' . $routeFile['origen'][$i], 'vendor/' . $routeFile['destino'][$i])){
                        $eventosArchivos[$i]['Remplazo'] = ('Se Remplazo El Archivo [ ' . $routeFile['origen'][$i] . ' => vendor/' . $routeFile['destino'][$i] . ' ]');
                    } else {
                        $eventosArchivos[$i]['Remplazo'] =('No Se Logro Remplzar El Archivo [ ' . $routeFile['origen'][$i] . ' ], Puede Que El Archivo No Se Encuentre En La Carpeta "File" O Tenga Un Nombre Diferente Al Listado.');
                    }

                    /* Imprimir Resultado */
                    $this->line('');
                    $this->line('Archivo => '. $routeFile['origen'][$i]);
                    $this->info($eventosArchivos[$i]['Validacion']);
                    $this->info($eventosArchivos[$i]['Remplazo']);

                }

            } else {

                /* Fin del Proceso por no existir listado coherente a Remplazar */
                $this->error('No Concuerda La Cantidad De Archivos Origen Con Las Rutas De Destino, No Se Puede Ejecutar El Comando De Remplazo De Archivos, Hasta Ajustar El Archivo => [app\Console\Commands\FlushVendor\Routes.php].');

            }

        } else {

            /* Fin del Proceso de Archivos no existir listado a Remplazar */
            $this->info('No Se Encontraron Archivos Listados A Remplazar.');

        }


        /* Proceso para Carpetas */
        $this->line('');
        $this->line('----- :::  CARPETAS  ::: -----');

        /* Validacion Cantidad de Archivos de Origen */
        $cantDirectoriosO = count($routeDir['origen']);
        $this->info('Cantidad De Carpetas Listadas ' . $cantDirectoriosO);

        if ($cantDirectoriosO > 0) {

            $cantDirectoriosD = count($routeDir['destino']);
            $this->info('Cantidad De Rutas De Carpetas destino Listadas ' . $cantDirectoriosD);

            if ($cantDirectoriosO == $cantDirectoriosD) {

                $this->info('Inicio Ejecucion De Remplazos');

                /**
                 * Inicio de los Remplazos de los Directorios
                 */
                $eventosDirectorios = [];

                for ($i = 0; $i < $cantDirectoriosO; $i++) {

                    /* Validacion de Archivo en Destino */
                    if (is_dir('vendor/' . $routeDir['destino'][$i])) {

                        /* Validar Archivos Dentro del Destino */
                        $archivos = glob('vendor/' . $routeDir['destino'][$i] .'/*.*');

                        /* Si existen archivos se eliminan */
                        if (count($archivos) > 0) {

                            /* Eliminacion uno a uno de los archivos */
                            foreach ($archivos as $archivo) {
                                unlink($archivo);
                            }

                        }

                        $eventosDirectorios[$i]['Validacion'] = ('Directorio [ ' . $routeDir['origen'][$i] . ' ], Encontrado En La Ruta De Destino, Vaciado Para Copiar Nuevos Archivos.');

                    } else {

                        /* Crear Carpeta Con permisos Globales. */
                        mkdir('vendor/' . $routeDir['destino'][$i], 0777);

                        $eventosDirectorios[$i]['Validacion'] =('En La Ruta Destino, No Existe Un Directorio Con El Nombre [ ' . $routeDir['origen'][$i] . ' ], Por Lo Cual Se Copiara El Directorio De Origen Sin Afectar Ningun Directorio Existente.');

                    }

                    /* Copia de Archivos de la carpeta anterior a la nueva */

                    $archivosOrigen = glob('app/Console/Commands/FlushVendor/Directories/' . $routeDir['origen'][$i] .'/*.*');

                    if (count($archivosOrigen) > 0) {

                        $archivosRecorridos = [];

                        foreach ($archivosOrigen as $archivoOrigen) {

                            /* Nombre del Archivo */
                            $nombreArchivo = str_replace('app/Console/Commands/FlushVendor/Directories/' . $routeDir['origen'][$i], '', $archivoOrigen);

                            if(copy($archivoOrigen, 'vendor/' . $routeDir['destino'][$i] . '/' . $nombreArchivo)){
                                array_push($archivosRecorridos, 'Se Copio Exitosamente El Archivo => ' . $nombreArchivo);
                            } else {
                                array_push($archivosRecorridos, 'No Se Logro Copiar El Archivo => ' . $nombreArchivo);
                            }
                        }

                        $eventosDirectorios[$i]['Remplazo'] = ('Se Recorrieron Todos Los Archivos Alojados En La Carpeta De Origen.');

                    } else {

                        $eventosDirectorios[$i]['Remplazo'] = ('La Carpeta De Origen Esta Vacia, Por Lo Cual No Se Insertan Datos A La Carpeta Del Vendor.');

                    }

                    /* Imprimir Resultado */
                    $this->line('');
                    $this->line('Directorio => '. $routeDir['origen'][$i]);
                    $this->info($eventosDirectorios[$i]['Validacion']);
                    $this->info($eventosDirectorios[$i]['Remplazo']);
                    if (count($archivosRecorridos) > 0) {
                        foreach ($archivosRecorridos as $archivoRecorrido) {
                            $this->info($archivoRecorrido);

                        }
                    }

                }

            } else {

                /* Fin del Proceso por no existir listado coherente a Remplazar */
                $this->error('No Concuerda La Cantidad De Carpetas Origen Con Las Rutas De Destino, No Se Puede Ejecutar El Comando Hasta Ajustar El Archivo => [app\Console\Commands\FlushVendor\Routes.php].');

            }

        } else {

            /* Fin del Proceso de Archivos no existir listado a Remplazar */
            $this->info('No Se Encontraron Carpetas Listadas A Remplazar.');

        }

        /* Cierre */
        $this->line('');
        $this->info('Proceso Completado.');
        $this->line('End FlushVendor Artisan Utilities');
    }
}
