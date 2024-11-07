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



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
Route::post('logout', [AuthController::class, 'logout']);

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/search', [CourseController::class, 'search']);
Route::post('/courses/{course}/enroll', [InscriptionController::class, 'store']);
Route::get('/courses/{course}/videos', [VideoController::class, 'index']);
Route::post('/videos/{video}/comments', [CommentController::class, 'store']);
Route::post('/videos/{video}/like', [LikeController::class, 'like']);
Route::post('/videos/{video}/unlike', [LikeController::class, 'unlike']);
Route::post('/inscriptions/{inscription}/progress', [InscriptionController::class, 'updateProgress']);
});

