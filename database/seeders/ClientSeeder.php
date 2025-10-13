<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@email.com',
                'phone' => '01 23 45 67 89',
                'address' => '123 Rue de la Paix, 75001 Paris',
            ],
            [
                'name' => 'Marie Durand',
                'email' => 'marie.durand@email.com',
                'phone' => '01 98 76 54 32',
                'address' => '456 Avenue des Champs, 75008 Paris',
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@email.com',
                'phone' => '01 55 44 33 22',
                'address' => '789 Boulevard Saint-Germain, 75006 Paris',
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie.bernard@email.com',
                'phone' => '01 11 22 33 44',
                'address' => '321 Rue de Rivoli, 75004 Paris',
            ],
            [
                'name' => 'Thomas Laurent',
                'email' => 'thomas.laurent@email.com',
                'phone' => '01 77 88 99 00',
                'address' => '654 Place de la République, 75011 Paris',
            ],
            [
                'name' => 'Julie Moreau',
                'email' => 'julie.moreau@email.com',
                'phone' => '01 66 55 44 33',
                'address' => '987 Rue de la Roquette, 75011 Paris',
            ],
            [
                'name' => 'David Petit',
                'email' => 'david.petit@email.com',
                'phone' => '01 22 33 44 55',
                'address' => '147 Rue de Charonne, 75011 Paris',
            ],
            [
                'name' => 'Camille Rousseau',
                'email' => 'camille.rousseau@email.com',
                'phone' => '01 99 88 77 66',
                'address' => '258 Avenue de la République, 75011 Paris',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
