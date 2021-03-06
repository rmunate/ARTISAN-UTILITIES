# Artisan-Git V 2.0.0 (2022-07-21)(Reescrito)
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

```sh
app\Console
```

![image](https://user-images.githubusercontent.com/91748598/180231263-fb5183cd-0b1e-453b-81fc-8916e3be2e78.png)


## Comandos

Podrá invocar el comando que requiera desde cualquier terminal sobre la carpeta principal del proyecto.

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| php artisan FlushCache | Limpie su proyecto de manera completa con un solo comando, en el terminal que esté usando se listará las limpiezas ejecutadas, es importante que cuente con conexión a la base de datos del proyecto ya que ejecuta limpiezas en tablas propias del Framework. Adicional el comando revisará la carpeta Storage de su Proyecto la cual ajustará de llegar a ser necesario. |

```sh
php artisan FlushCache
```

![image](https://user-images.githubusercontent.com/91748598/169712866-3866dd82-9b8f-43ac-b7c4-ad6e8e94d03d.png)

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| php artisan GitPush Rama _--m=“Comentario commit”_ | Cargue los cambios de su repositorio a GIT con el comando recomendado, este comando garantizará que antes de cargar los cambios, los archivos que pueden generar conflictos con otras ramas del mismo proyecto, sean corregidos o eliminados, el comando puede ejecutarse con un comentario personalización o sin el, con el solo hecho de llegar hasta el nombre de la rama será suficiente. Además, el comando le preguntará si desea descargar cambios de alguna rama remota del proyecto, ejecutando la tarea por usted. |

```sh
php artisan GitPush Rama --m=“Comentario commit”
```

Estructura Corta
![image](https://user-images.githubusercontent.com/91748598/169713010-3df69b26-cf19-4414-bf5c-05d23133b6aa.png)

Confirmación de Bajar Cambios
![image](https://user-images.githubusercontent.com/91748598/169713035-8df77098-82f3-4e2b-84f1-2b66a027bf4d.png)


| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| php artisan GitReset _--log=“10”_ | GitReset es el comando que usamos cuando queremos mover el repositorio a una confirmación anterior, descartando cualquier cambio realizado después de esa confirmación, este comando es el igual a (git reset), se debe ejecutar bajo la responsabilidad que amerita el regresar el proyecto descartando los cambios posteriores. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |

```sh
php artisan GitReset
```

![image](https://user-images.githubusercontent.com/91748598/169713175-16c5f349-f745-4bdb-ab0d-80099eec639f.png)

| COMANDO | DESCRIPCIÓN |
| ----------- | ----------- |
| php artisan GitRevert _--log=“10”_ | GitRevert es el comando que usamos cuando queremos revertir el efecto de algunos cambios anteriores (posiblemente defectuosos), no elimina los cambios solo revierte lo implementado en las confirmaciones posteriores a la seleccionada para revertir. El comando recibe el parámetro --log el cual permite indicar cuantos cambios se desean listar para seleccionar a cual regresar, de no especificarse, se listaran los últimos 10 cambios cargados. |

```sh
php artisan GitRevert
```

![image](https://user-images.githubusercontent.com/91748598/169713225-9d61a55f-a8ab-44eb-ae7b-6b70e7ba2584.png)

## Desarrollador

Ingeniero, Raúl Mauricio Uñate Castro
raulmauriciounate@gmail.com

## Licencia
MIT
