# Proyecto API de Cursos en Línea

Este proyecto es una API desarrollada en Laravel para gestionar cursos en línea. La API permite a los usuarios registrarse, inscribirse en cursos, interactuar con videos mediante comentarios y likes, y rastrear su progreso.

## Tabla de Contenidos

-   [Requisitos](#requisitos)
-   [Instalación](#instalación)
-   [Configuración](#configuración)
-   [Ejecución](#ejecución)
-   [Rutas de la API](#rutas-de-la-api)
-   [Pruebas](#pruebas)
-   [Documentación de Código](#documentación-de-código)

## Requisitos

-   **PHP**: >= 8.0
-   **Composer**
-   **Laravel**: >= 8.x
-   **MySQL** u otro sistema de base de datos compatible

## Instalación

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/tu_usuario/tu_repositorio.git
    cd tu_repositorio
    ```

Instalar dependencias:
composer install
Crear el archivo .env desde el archivo de ejemplo y configurar las variables de entorno:

cp .env.example .env
Generar una clave de aplicación:

php artisan key:generate
Configuración
Configura la base de datos en el archivo .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
Ejecuta las migraciones y los seeders para poblar la base de datos:

php artisan migrate --seed
Configura Sanctum para la autenticación de usuarios:

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
Ejecución
Inicia el servidor de desarrollo:

php artisan serve
La API estará disponible en http://localhost:8000.

Rutas de la API
Las rutas de la API incluyen:

Autenticación

POST /register: Registro de usuario
POST /login: Inicio de sesión
POST /logout: Cerrar sesión (requiere autenticación)
Cursos

GET /courses: Lista de todos los cursos
GET /courses/search: Búsqueda de cursos
POST /courses/{course}/enroll: Inscripción a un curso (requiere autenticación)
Videos

GET /courses/{course}/videos: Lista de videos de un curso (requiere autenticación)
Comentarios

POST /videos/{video}/comments: Agregar un comentario a un video (requiere autenticación)
Likes

POST /videos/{video}/like: Dar like a un video (requiere autenticación)
POST /videos/{video}/unlike: Quitar like de un video (requiere autenticación)
Progreso de Cursos

POST /inscriptions/{inscription}/progress: Actualizar progreso del usuario en un curso (requiere autenticación)
Pruebas
Para ejecutar las pruebas:

php artisan test
Las pruebas cubren el funcionamiento básico de la API, asegurando que las funcionalidades principales como registro, inscripción y actualización de progreso funcionen correctamente.

Documentación de Código
El código contiene documentación en forma de comentarios, especialmente en las clases de controladores y modelos. Las funciones principales incluyen comentarios detallados sobre su funcionalidad y parámetros.
