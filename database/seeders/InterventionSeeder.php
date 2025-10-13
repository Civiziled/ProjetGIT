<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Intervention;
use App\Models\Client;
use App\Models\User;

class InterventionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $technicians = User::where('role', 'technicien')->get();

        $interventions = [
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => $technicians->random()->id,
                'description' => 'L\'ordinateur portable ne démarre plus. Écran noir au démarrage, aucun son du ventilateur.',
                'device_type' => 'Ordinateur portable',
                'priority' => 'high',
                'status' => 'diagnostic',
                'scheduled_date' => now()->addDays(2),
                'internal_notes' => 'Problème probablement lié à la carte mère ou l\'alimentation.',
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => $technicians->random()->id,
                'description' => 'Écran de smartphone fissuré après une chute. L\'écran tactile ne répond plus correctement.',
                'device_type' => 'Smartphone',
                'priority' => 'medium',
                'status' => 'en_reparation',
                'scheduled_date' => now()->addDays(1),
                'internal_notes' => 'Remplacement de l\'écran nécessaire. Pièce commandée.',
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => null,
                'description' => 'Tablette qui se charge très lentement et se décharge rapidement.',
                'device_type' => 'Tablette',
                'priority' => 'low',
                'status' => 'nouvelle_demande',
                'scheduled_date' => null,
                'internal_notes' => null,
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => $technicians->random()->id,
                'description' => 'Ordinateur de bureau qui fait des bruits anormaux et surchauffe.',
                'device_type' => 'Ordinateur de bureau',
                'priority' => 'urgent',
                'status' => 'diagnostic',
                'scheduled_date' => now()->addHours(4),
                'internal_notes' => 'Problème de ventilateur probable. Risque de surchauffe.',
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => $technicians->random()->id,
                'description' => 'Laptop qui plante régulièrement avec des écrans bleus.',
                'device_type' => 'Ordinateur portable',
                'priority' => 'high',
                'status' => 'termine',
                'scheduled_date' => now()->subDays(1),
                'internal_notes' => 'Problème de RAM résolu. Remplacement des barrettes défectueuses.',
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => $technicians->random()->id,
                'description' => 'Smartphone qui ne se connecte plus au WiFi.',
                'device_type' => 'Smartphone',
                'priority' => 'medium',
                'status' => 'non_reparable',
                'scheduled_date' => now()->subDays(3),
                'internal_notes' => 'Carte WiFi endommagée. Coût de réparation trop élevé.',
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => $technicians->random()->id,
                'description' => 'Tablette avec écran qui clignote et affiche des lignes colorées.',
                'device_type' => 'Tablette',
                'priority' => 'medium',
                'status' => 'en_reparation',
                'scheduled_date' => now()->addDays(3),
                'internal_notes' => 'Problème d\'affichage. Test en cours pour identifier la cause.',
            ],
            [
                'client_id' => $clients->random()->id,
                'assigned_technician_id' => null,
                'description' => 'Ordinateur portable qui ne charge plus la batterie.',
                'device_type' => 'Ordinateur portable',
                'priority' => 'high',
                'status' => 'nouvelle_demande',
                'scheduled_date' => null,
                'internal_notes' => null,
            ],
        ];

        foreach ($interventions as $intervention) {
            Intervention::create($intervention);
        }
    }
}
