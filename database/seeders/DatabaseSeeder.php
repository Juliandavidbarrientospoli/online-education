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

        // Crear usuarios ficticios con nombres reales
        $userNames = ['Juan Perez', 'Ana García', 'Luis Ramírez', 'María López', 'Carlos Fernández', 'Elena Martínez', 'Pedro González', 'Lucía Rodríguez', 'Sofía Sánchez'];
        foreach ($userNames as $index => $name) {
            $user = User::firstOrCreate(['email' => "user{$index}@example.com"], [
                'name' => $name,
                'password' => Hash::make('password'),
            ]);
            $user->assignRole($userRole);
        }

        // 3. Crear categorías
        $categories = [
            'Matemáticas',
            'Ciencias',
            'Física',
            'Informática',
            'Literatura'
        ];

        foreach ($categories as $categoryName) {
            $categoryInstances[$categoryName] = Category::firstOrCreate(['name' => $categoryName]);
        }

        // 4. Crear cursos
        $courses = [
            [
                'title' => 'Curso de Matemáticas Básicas',
                'description' => 'Aprende los conceptos básicos de las matemáticas.',
                'age_group' => '5-8',
                'category' => 'Matemáticas',
                'image_url' => 'courses/Ll5q3YJD2ATRzDqIsoazEPNgJ3f6FPdqAENSLVlh.jpg',
            ],
            [
                'title' => 'Curso de Ciencias Naturales',
                'description' => 'Introducción a las ciencias naturales.',
                'age_group' => '9-13',
                'category' => 'Ciencias',
                'image_url' => 'courses/QyTeIvKJ1zVhQmckrXnUUGEDjEDbpDfjqZ8P0pxO.jpg',
            ],
            [
                'title' => 'Física Avanzada',
                'description' => 'Explora los principios avanzados de la física.',
                'age_group' => '16+',
                'category' => 'Física',
                'image_url' => 'courses/BCb3ou7v3NYDbdv6qOVg6WBYvqzYtD9lqJX7viRm.jpg',
            ],
            [
                'title' => 'Introducción a la Informática',
                'description' => 'Conceptos básicos de la informática y tecnología.',
                'age_group' => '14-16',
                'category' => 'Informática',
                'image_url' => 'courses/dnII67D8OM8FRkjM2Na2ZkSsmMw7NF5mTCpNAmSV.jpg',
            ],
            [
                'title' => 'Historia de la Literatura',
                'description' => 'Descubre los clásicos de la literatura mundial.',
                'age_group' => '16+',
                'category' => 'Literatura',
                'image_url' => 'courses/Gp6GZD4nFcAYoa1UNGZ03wsInH8YBVgFyze895uk.jpg',
            ]
        ];

        foreach ($courses as $courseData) {
            $courseInstances[$courseData['title']] = Course::firstOrCreate(['title' => $courseData['title']], [
                'description' => $courseData['description'],
                'age_group' => $courseData['age_group'],
                'category_id' => $categoryInstances[$courseData['category']]->id,
                'image_url' => $courseData['image_url'],
                'created_by' => $admin->id,
            ]);
        }

        // 5. Define los datos de los videos y asigna a todos los cursos
        $videos = [
            'Curso de Matemáticas Básicas' => [
                ['title' => 'Introducción a las Matemáticas', 'url' => 'https://www.youtube.com/watch?v=FKkDGow6Fpw'],
                ['title' => 'Números con Signo', 'url' => 'https://www.youtube.com/watch?v=P61RkhoDM6A'],
                ['title' => 'Fracciones', 'url' => 'https://www.youtube.com/watch?v=dOBYHkWni9s'],
                ['title' => 'Signos de Agrupación', 'url' => 'https://www.youtube.com/watch?v=Fs3wd8Mt_w4'],
                ['title' => 'Exponentes', 'url' => 'https://www.youtube.com/watch?v=3zsqtpYsq-A']
            ],
            'Curso de Ciencias Naturales' => [
                ['title' => 'Introducción a las Ciencias Naturales', 'url' => 'https://www.youtube.com/watch?v=1a8pI65emDE'],
                ['title' => 'El Ciclo del Agua', 'url' => 'https://www.youtube.com/watch?v=ZzY5-NZSzVw'],
                ['title' => 'La Célula y sus Funciones', 'url' => 'https://www.youtube.com/watch?v=URUJD5NEXC8']
            ],
            'Física Avanzada' => [
                ['title' => 'Mecánica Cuántica: Principios Básicos', 'url' => 'https://www.youtube.com/watch?v=ScXf8gk5IM4'],
                ['title' => 'Relatividad General: Una Introducción', 'url' => 'https://www.youtube.com/watch?v=4yyb_RNJWUM'],
                ['title' => 'Física de Partículas: El Modelo Estándar', 'url' => 'https://www.youtube.com/watch?v=Rkhb8zN4uYc']
            ],
            'Introducción a la Informática' => [
                ['title' => 'Conceptos Básicos de Informática', 'url' => 'https://www.youtube.com/watch?v=info-basics'],
                ['title' => 'Historia de las Computadoras', 'url' => 'https://www.youtube.com/watch?v=comp-history'],
                ['title' => 'Fundamentos de Programación', 'url' => 'https://www.youtube.com/watch?v=program-fundamentals']
            ],
            'Historia de la Literatura' => [
                ['title' => 'Nuevos Autores del Siglo XXI', 'url' => 'https://www.youtube.com/watch?v=xxabcde1234'],
                ['title' => 'Movimientos Literarios Recientes', 'url' => 'https://www.youtube.com/watch?v=xxxyzxyz5678'],
                ['title' => 'La Evolución de la Novela Moderna', 'url' => 'https://www.youtube.com/watch?v=xxqrstuv9012']
            ]
        ];

        foreach ($videos as $courseTitle => $courseVideos) {
            $course = Course::where('title', $courseTitle)->first();
            if ($course) {
                foreach ($courseVideos as $videoData) {
                    Video::firstOrCreate([
                        'title' => $videoData['title'],
                        'url' => $videoData['url'],
                        'course_id' => $course->id,
                        'category_id' => $course->category_id,
                    ]);
                }
            }
        }

        // 6. Crear inscripciones y progreso para usuarios
        foreach (User::all()->where('email', '!=', 'admin@example.com') as $user) {
            foreach ($courseInstances as $course) {
                $video = Video::where('course_id', $course->id)->inRandomOrder()->first();

                Inscription::firstOrCreate([
                    'course_id' => $course->id,
                    'user_id' => $user->id
                ], [
                    'progress' => rand(10, 100),
                    'current_video_id' => $video ? $video->id : null, // Si no hay video, asigna null
                ]);
            }
        }

        // 7. Crear comentarios para cada video por diferentes usuarios con nombres y comentarios realistas
        $comments = [
            'Increíble introducción, me ha encantado la claridad del contenido.',
            'Este tema es fascinante. ¡Gracias por compartirlo!',
            'El curso está muy bien estructurado. Me ayudó a comprender mejor los conceptos.',
            'Excelente contenido. El profesor explica muy bien cada punto.',
            'Me gustaría ver más ejemplos prácticos en los próximos módulos.'
        ];

        foreach (Video::all() as $video) {
            foreach (User::all()->where('email', '!=', 'admin@example.com')->random(5) as $user) {
                Comment::firstOrCreate(['video_id' => $video->id, 'user_id' => $user->id], [
                    'content' => $comments[array_rand($comments)],
                    'approved' => true,
                ]);
            }
        }
    }
}
