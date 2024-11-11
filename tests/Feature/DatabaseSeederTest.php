<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;
use App\Models\Category;
use App\Models\Inscription;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Ejecuta el seeder para que los datos de prueba se carguen en la base de datos
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /** @test */
    public function it_seeds_users_correctly()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com'
        ]);

        $this->assertDatabaseCount('users', 10); // 1 admin + 9 users
    }

    /** @test */
    public function it_seeds_courses_correctly()
    {
        $this->assertDatabaseHas('courses', [
            'title' => 'Introducción a la Informática'
        ]);

        $this->assertDatabaseCount('courses', 5);
    }

    /** @test */
    public function it_seeds_categories_correctly()
    {
        $this->assertDatabaseHas('categories', [
            'name' => 'Informática'
        ]);

        $this->assertDatabaseCount('categories', 5);
    }

    /** @test */
    public function it_seeds_videos_for_courses_correctly()
    {
        $course = Course::where('title', 'Introducción a la Informática')->first();
        $this->assertNotNull($course, 'El curso de "Introducción a la Informática" no existe.');

        // Verifica que el curso tiene al menos un video asociado
        $this->assertGreaterThan(0, $course->videos()->count(), 'El curso no tiene videos asociados.');
    }

    /** @test */
    public function it_seeds_inscriptions_correctly()
    {
        // Confirma que existen inscripciones
        $this->assertDatabaseHas('inscriptions', []);

        // Verifica que el número de inscripciones coincida con el número esperado
        $expectedCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->count() * Course::count();

        $this->assertEquals($expectedCount, Inscription::count(), 'La cantidad de inscripciones no coincide.');
    }
}
