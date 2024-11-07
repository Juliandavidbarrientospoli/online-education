<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders de la base de datos.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'julian@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
    }
}
