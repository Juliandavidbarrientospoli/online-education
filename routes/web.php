<?php

use Illuminate\Support\Facades\Route;
use App\http\Livewire\CourseIndex;
use App\http\Livewire\CourseShow;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UserController;

use App\Http\Livewire\CourseDetails;

use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');
// Ruta para mostrar el listado de cursos
Route::get('/dashboard', CourseIndex::class)->name('dashboard');
Route::get('/courses', CourseIndex::class)->name('courses.index');
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])->name('inscriptions.index');
Route::post('/courses/{course}/inscription', [InscriptionController::class, 'store'])->name('courses.inscription');
Route::get('/courses/{courseId}/details', CourseDetails::class)->name('courses.details');
Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::get('/admin/videos/create', [VideoController::class, 'create'])->name('videos.create');

Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');

Route::get('/admin/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
// Ruta para mostrar un curso específico
Route::get('/courses/{course}', CourseShow::class)->name('courses.show');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Ruta para mostrar el listado de cursos
Route::get('/courses', CourseIndex::class)->name('courses.index');
