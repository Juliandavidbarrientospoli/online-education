<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Video;
use App\Models\Inscription;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // 2. Crear usuarios y asignar roles
        $admin = User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        $user1 = User::firstOrCreate(['email' => 'user1@example.com'], [
            'name' => 'Regular User One',
            'password' => Hash::make('password'),
        ]);
        $user1->assignRole($userRole);

        $user2 = User::firstOrCreate(['email' => 'user2@example.com'], [
            'name' => 'Regular User Two',
            'password' => Hash::make('password'),
        ]);
        $user2->assignRole($userRole);

        // 3. Crear categorías
        $mathCategory = Category::firstOrCreate(['name' => 'Matemáticas']);
        $scienceCategory = Category::firstOrCreate(['name' => 'Ciencias']);
        $historyCategory = Category::firstOrCreate(['name' => 'Historia']);
        $literatureCategory = Category::firstOrCreate(['name' => 'Literatura']);

        // 4. Crear cursos
        $course1 = Course::firstOrCreate(['title' => 'Curso de Matemáticas Básicas'], [
            'description' => 'Aprende los conceptos básicos de las matemáticas.',
            'age_group' => '5-8',
            'category_id' => $mathCategory->id,
            'image_url' => 'curso-matematicas.jpg',
            'created_by' => $admin->id,
        ]);

        $course2 = Course::firstOrCreate(['title' => 'Física Básica'], [
            'description' => 'Explora los principios de la física.',
            'age_group' => '9-13',
            'category_id' => $scienceCategory->id,
            'image_url' => 'curso-fisica-basica.jpg',
            'created_by' => $admin->id,
        ]);

        $course3 = Course::firstOrCreate(['title' => 'Física Avanzada'], [
            'description' => 'Aprende los conceptos avanzados de la física.',
            'age_group' => '16+',
            'category_id' => $scienceCategory->id,
            'image_url' => 'curso-fisica-avanzada.jpg',
            'created_by' => $admin->id,
        ]);

        $course4 = Course::firstOrCreate(['title' => 'Matemáticas Avanzadas'], [
            'description' => 'Explora los principios avanzados de las matemáticas.',
            'age_group' => '9-13',
            'category_id' => $mathCategory->id,
            'image_url' => 'curso-matematicas-avanzada.jpg',
            'created_by' => $admin->id,
        ]);

        // 5. Crear videos
        $video1 = Video::firstOrCreate(['course_id' => $course1->id, 'title' => 'Introducción a las Matemáticas'], [
            'url' => 'https://www.youtube.com/watch?v=XXXXXXX',
            'category_id' => $mathCategory->id,
        ]);

        $video2 = Video::firstOrCreate(['course_id' => $course2->id, 'title' => 'Ley de Newton'], [
            'url' => 'https://www.youtube.com/watch?v=YYYYYYY',
            'category_id' => $scienceCategory->id,
        ]);

        $video3 = Video::firstOrCreate(['course_id' => $course3->id, 'title' => 'Teoría de la Relatividad'], [
            'url' => 'https://www.youtube.com/watch?v=ZZZZZZZ',
            'category_id' => $scienceCategory->id,
        ]);

        $video4 = Video::firstOrCreate(['course_id' => $course4->id, 'title' => 'Cálculo Diferencial'], [
            'url' => 'https://www.youtube.com/watch?v=WWWWWWW',
            'category_id' => $mathCategory->id,
        ]);

        // 6. Crear inscripciones
        Inscription::firstOrCreate(['course_id' => $course1->id, 'user_id' => $user1->id], [
            'progress' => 50,
            'current_video_id' => $video1->id,
        ]);

        Inscription::firstOrCreate(['course_id' => $course2->id, 'user_id' => $user2->id], [
            'progress' => 30,
            'current_video_id' => $video2->id,
        ]);

        // 7. Crear comentarios para cada video
        Comment::firstOrCreate(['video_id' => $video1->id, 'user_id' => $user1->id], [
            'content' => 'Este curso de matemáticas es excelente para principiantes.',
            'approved' => true,
        ]);

        Comment::firstOrCreate(['video_id' => $video2->id, 'user_id' => $user2->id], [
            'content' => 'Me gustó mucho la explicación de las leyes de Newton.',
            'approved' => true,
        ]);

        Comment::firstOrCreate(['video_id' => $video3->id, 'user_id' => $user1->id], [
            'content' => 'Muy interesante el tema de la relatividad.',
            'approved' => true,
        ]);

        Comment::firstOrCreate(['video_id' => $video4->id, 'user_id' => $user2->id], [
            'content' => 'El curso de cálculo diferencial es muy completo.',
            'approved' => true,
        ]);
    }
}
