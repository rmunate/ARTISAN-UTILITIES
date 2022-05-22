# Artisan-Git
## _Porque siempre puede ser más fácil trabajar en equipo._

[![N|Solid](https://i.ibb.co/ZLzQTpm/Firma-Git-Hub.png)](#)

Este paquete contiene diversos comandos de Artisan que buscan ejecutar diferentes trabajos relacionados con el control de cambios, el trabajo comunitario y la optimización del proyecto. Todo desde la facilidad del terminal.
Solo funciona para proyectos Laravel ^5.5

## Características

-	Ejecute comandos rápidos desde la terminal y deje que el paquete trabaje por usted.
-	Ejecute cargues y descargues de cambios en GIT con las mejores prácticas.
-	Limpie su proyecto las veces que quiera con una sola línea.
-	Conserve su configuración manual de paquetes del Vendor sin importar los updates que ejecute.

## Instalación

Descargue el contenido del repositorio a su equipo.
Copie el contenido del paquete a la ruta _app\Console_

![image](https://user-images.githubusercontent.com/91748598/169712357-a675d3f6-094f-4434-bcfa-403ca92fb160.png)


```sh
App\Clases\EnvironmentMessage.php
```

Esta carpeta se carga por defecto dentro del Framework, por lo cual podremos llamar la clase en cualquier controlador con total libertad.

Llamado y uso de Clase

```sh
<?php
use App\Clases\EnvironmentMessage;
```

## Métodos

Podrá invocar el método que requiera de la clase.
Listado Actual de Métodos

METODOS PARA USO EN CONTROLADORES

| METODO | DESCRIPCIÓN |
| ------ | ------ |
| EnvironmentMessage::all() | Retorna un objeto con los datos del entorno en Uso. |

METODOS PARA USO EN BLADE O EN FRONT
| METODO | DESCRIPCIÓN |
| ------ | ------ |
| EnvironmentMessage::html([inf,dev,pro]) | Método para generar la barra HTML en el Front de Blade, tambien se puede generar una peticion en el layaut al back para generar esta barra en cualquier otro tipo de Front como Vue, React ó Angular |

En este último método se podrá, enviar como primer argumento una combinación de máximo cuatro letras las cuales devolverán la siguiente información de manera correspondiente.

Argumento#1 (Opcional) | 
P = Versión de PHP, 
L = Versión de Laravel, 
E = Entorno (Local, QA, Producción), 
H = Protocolo HTTP ó HTTPS, 

Argumento#2 (Opcional) | 
String Nombre Desarrollador o Casa de Desarrollo

Argumento#3 (Opcional) | 
URL de Producción


_Código Plantila Blade Laravel_
```sh
{!! App\Clases\EnvironmentMessage::html('PLEH','Altum Digital','strategy4.com.co') !!}
```

## Desarrollador

Ingeniero, Raúl Mauricio Uñate Castro
sacon-raulmauricio@hotmail.com

## Licencia
MIT
