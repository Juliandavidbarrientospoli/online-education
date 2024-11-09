<?php

namespace App\Providers;

use App\Http\Livewire\CourseIndex;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\Admin\CourseCreate;
use App\Http\Livewire\CourseDetails;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Livewire::component('course-index', CourseIndex::class);
        Livewire::component('course-details', CourseDetails::class);
    }
}
