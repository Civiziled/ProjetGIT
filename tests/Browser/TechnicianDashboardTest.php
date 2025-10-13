<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Client;
use App\Models\Intervention;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TechnicianDashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un technicien
        $this->technician = User::create([
            'name' => 'Technicien Test',
            'email' => 'technicien@test.com',
            'password' => bcrypt('password'),
            'role' => 'technicien',
            'email_verified_at' => now(),
        ]);

        // Créer des données de test
        $this->createTestData();
    }

    private function createTestData()
    {
        // Créer un client
        $client = Client::create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'phone' => '01 23 45 67 89',
        ]);

        // Créer des interventions assignées au technicien
        Intervention::create([
            'client_id' => $client->id,
            'assigned_technician_id' => $this->technician->id,
            'description' => 'Problème de démarrage',
            'device_type' => 'Ordinateur portable',
            'priority' => 'high',
            'status' => 'diagnostic',
        ]);

        Intervention::create([
            'client_id' => $client->id,
            'assigned_technician_id' => $this->technician->id,
            'description' => 'Écran fissuré',
            'device_type' => 'Smartphone',
            'priority' => 'medium',
            'status' => 'en_reparation',
        ]);

        // Créer une intervention non assignée
        Intervention::create([
            'client_id' => $client->id,
            'description' => 'Problème de charge',
            'device_type' => 'Tablette',
            'priority' => 'low',
            'status' => 'nouvelle_demande',
        ]);
    }

    /**
     * Test de connexion technicien
     */
    public function test_technician_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'technicien@test.com')
                    ->type('password', 'password')
                    ->press('Se connecter')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Tableau de bord - Technicien');
        });
    }

    /**
     * Test d'affichage du tableau de bord technicien
     */
    public function test_technician_dashboard_display()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->technician)
                    ->visit('/dashboard')
                    ->assertSee('Tableau de bord - Technicien')
                    ->assertSee('Mes interventions')
                    ->assertSee('En cours')
                    ->assertSee('Mes interventions en cours')
                    ->assertSee('Récemment terminées');
        });
    }

    /**
     * Test de visualisation des interventions assignées
     */
    public function test_view_assigned_interventions()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->technician)
                    ->visit('/interventions')
                    ->assertSee('Interventions')
                    ->assertSee('Client Test')
                    ->assertSee('Problème de démarrage')
                    ->assertSee('Écran fissuré')
                    ->assertDontSee('Problème de charge'); // Intervention non assignée
        });
    }

    /**
     * Test de modification d'intervention
     */
    public function test_edit_intervention()
    {
        $intervention = Intervention::where('assigned_technician_id', $this->technician->id)->first();

        $this->browse(function (Browser $browser) use ($intervention) {
            $browser->loginAs($this->technician)
                    ->visit("/interventions/{$intervention->id}/edit")
                    ->assertSee('Modifier l\'intervention')
                    ->type('internal_notes', 'Notes techniques ajoutées')
                    ->select('status', 'en_reparation')
                    ->press('Mettre à jour')
                    ->assertSee('Intervention mise à jour avec succès');
        });
    }

    /**
     * Test de changement de statut
     */
    public function test_change_intervention_status()
    {
        $intervention = Intervention::where('assigned_technician_id', $this->technician->id)->first();

        $this->browse(function (Browser $browser) use ($intervention) {
            $browser->loginAs($this->technician)
                    ->visit("/interventions/{$intervention->id}")
                    ->assertSee('Intervention #')
                    ->select('status', 'termine')
                    ->press('Mettre à jour')
                    ->assertSee('Statut mis à jour avec succès');
        });
    }

    /**
     * Test d'accès restreint aux interventions non assignées
     */
    public function test_cannot_access_unassigned_interventions()
    {
        $unassignedIntervention = Intervention::whereNull('assigned_technician_id')->first();

        $this->browse(function (Browser $browser) use ($unassignedIntervention) {
            $browser->loginAs($this->technician)
                    ->visit("/interventions/{$unassignedIntervention->id}")
                    ->assertSee('403'); // Page d'erreur d'autorisation
        });
    }

    /**
     * Test d'impossibilité de créer des clients
     */
    public function test_cannot_create_clients()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->technician)
                    ->visit('/clients/create')
                    ->assertSee('403'); // Page d'erreur d'autorisation
        });
    }
}
