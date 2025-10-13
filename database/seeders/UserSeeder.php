<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un administrateur
        User::create([
            'name' => 'Admin Atelier 404',
            'email' => 'admin@atelier404.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Créer des techniciens
        $technicians = [
            [
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@atelier404.com',
                'password' => Hash::make('password'),
                'role' => 'technicien',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@atelier404.com',
                'password' => Hash::make('password'),
                'role' => 'technicien',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@atelier404.com',
                'password' => Hash::make('password'),
                'role' => 'technicien',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Thomas Bernard',
                'email' => 'thomas.bernard@atelier404.com',
                'password' => Hash::make('password'),
                'role' => 'technicien',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($technicians as $technician) {
            User::create($technician);
        }
    }
}
