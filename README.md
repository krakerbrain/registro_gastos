## Registro de gastos

Esta es una aplicación web sencilla desarrollada en Laravel 9 y Bootstrap para el registro de gastos. La aplicación permite a los usuarios registrar cada uno de sus gastos diarios y ver un resumen de sus gastos totales.

## Características

-   Registro de gastos diarios
-   Visualización de un resumen de gastos totales
-   Fácil de usar y navegar
-   Diseño responsive basado en Bootstrap

## Requisitos

-   PHP >= 8.0
-   Composer
-   MySQL o MariaDB

## Instalación

-   Clona o descarga el repositorio en tu computadora.
-   Abre una terminal en la carpeta del proyecto y ejecuta el siguiente comando para instalar las dependencias:

```bash
    composer install
```

-   Copia el archivo .env.example a .env y edita las variables de configuración de la base de datos.
-   Ejecuta las migraciones para crear las tablas de la base de datos:

```bash
    php artisan migrate
```

-   Genera una clave de aplicación:

```bash
    php artisan key:generate
```

-   Inicia el servidor de desarrollo:

```bash
    php artisan serve
```

-   Abre el navegador en http://localhost:8000 para acceder a la aplicación.

## Uso

La aplicación consta de dos páginas principales: el formulario de registro de gastos y la página de resumen de gastos totales.

## Formulario de registro de gastos

La página de registro de gastos permite al usuario registrar un nuevo gasto. El usuario debe ingresar la descripción del gasto y el monto del gasto. Al hacer clic en el botón "Guardar", se guarda el gasto en la base de datos.

## Resumen de gastos totales

La página de resumen de gastos totales muestra una tabla con todos los gastos registrados por el usuario. La tabla incluye la fecha del gasto, la categoría del gasto y la cantidad del gasto. También se muestra la cantidad total de gastos registrados.

## Contribuciones

Si deseas contribuir a esta aplicación, siéntete libre de enviar un pull request o abrir un issue en el repositorio de GitHub. Agradezco cualquier contribución que me ayude a mejorar la aplicación.

## Creado por

Mario Montenegro
