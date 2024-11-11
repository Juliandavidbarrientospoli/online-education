<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\InscriptionController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas API para tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider dentro de un grupo que
| está asignado al grupo de middleware "api". ¡Disfruta construyendo tu API!
|
*/

// Rutas de autenticación
Route::post('register', [AuthController::class, 'register']); // Registro de usuario
Route::post('login', [AuthController::class, 'login']); // Inicio de sesión

// Rutas protegidas por autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']); // Cerrar sesión

    // Rutas de cursos
    Route::get('/courses', [CourseController::class, 'index']); // Lista de todos los cursos
    Route::get('/courses/search', [CourseController::class, 'search']); // Búsqueda de cursos
    Route::post('/courses/{course}/enroll', [InscriptionController::class, 'store']); // Inscripción a un curso

    // Rutas de videos
    Route::get('/courses/{course}/videos', [VideoController::class, 'index']); // Lista de videos de un curso

    // Rutas de comentarios
    Route::post('/videos/{video}/comments', [CommentController::class, 'store']); // Agregar comentario a un video

    // Rutas de likes
    Route::post('/videos/{video}/like', [LikeController::class, 'like']); // Dar like a un video
    Route::post('/videos/{video}/unlike', [LikeController::class, 'unlike']); // Quitar like de un video

    // Rutas de progreso en inscripciones
    Route::post('/inscriptions/{inscription}/progress', [InscriptionController::class, 'updateProgress']); // Actualizar progreso del usuario en un curso
});
