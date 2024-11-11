<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\{
    CourseIndex,
    CourseShow,
    CourseDetails,
    UserProgress,
    Admin\AdminUserProgress
};
use App\Http\Controllers\{
    CourseController,
    ProfileController,
    InscriptionController,
    AdminController,
    VideoController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Página de inicio
Route::view('/', 'welcome');

// Rutas públicas de cursos
Route::get('/courses', CourseIndex::class)->name('courses.index');
Route::get('/courses/{course}', CourseShow::class)->name('courses.show');
Route::get('/courses/{courseId}/details', CourseDetails::class)->name('courses.details');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', CourseIndex::class)->name('dashboard');

    // Profile Management
    Route::get('/profile', fn() => view('profile'))->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Course Inscriptions
    Route::post('/courses/{course}/inscription', [InscriptionController::class, 'store'])
        ->name('courses.inscription');
});

/*
|--------------------------------------------------------------------------
| User Role Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {
    // User Progress
    Route::get('/mi-progreso', UserProgress::class)->name('user.progress');
});

/*
|--------------------------------------------------------------------------
| Admin Role Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');

    // Course Management
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('courses.create');

    // Video Management
    Route::get('/admin/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/admin/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/admin/videos/create', [VideoController::class, 'store'])->name('videos.store');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');

    // Inscription Management
    Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])
        ->name('inscriptions.index');

    // User Progress Management
    Route::get('/admin/users/progress', AdminUserProgress::class)
        ->name('admin.users.progress');
});
