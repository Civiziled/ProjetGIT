<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Client;
use App\Models\Intervention;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminDashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un admin
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Créer des données de test
        $this->createTestData();
    }

    private function createTestData()
    {
        // Créer des clients
        $client1 = Client::create([
            'name' => 'Client Test 1',
            'email' => 'client1@test.com',
            'phone' => '01 23 45 67 89',
        ]);

        $client2 = Client::create([
            'name' => 'Client Test 2',
            'email' => 'client2@test.com',
            'phone' => '01 98 76 54 32',
        ]);

        // Créer des interventions
        Intervention::create([
            'client_id' => $client1->id,
            'description' => 'Problème de démarrage',
            'device_type' => 'Ordinateur portable',
            'priority' => 'high',
            'status' => 'nouvelle_demande',
        ]);

        Intervention::create([
            'client_id' => $client2->id,
            'description' => 'Écran fissuré',
            'device_type' => 'Smartphone',
            'priority' => 'medium',
            'status' => 'diagnostic',
        ]);
    }

    /**
     * Test de connexion admin
     */
    public function test_admin_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@test.com')
                    ->type('password', 'password')
                    ->press('Se connecter')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Tableau de bord - Administrateur');
        });
    }

    /**
     * Test d'affichage du tableau de bord admin
     */
    public function test_admin_dashboard_display()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/dashboard')
                    ->assertSee('Tableau de bord - Administrateur')
                    ->assertSee('Total interventions')
                    ->assertSee('Nouvelles demandes')
                    ->assertSee('Interventions non assignées')
                    ->assertSee('Interventions récentes');
        });
    }

    /**
     * Test de gestion des interventions
     */
    public function test_intervention_management()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->assertSee('Interventions')
                    ->assertSee('Client Test 1')
                    ->assertSee('Client Test 2')
                    ->clickLink('Voir', 'a[href*="/interventions/"]')
                    ->assertSee('Intervention #')
                    ->assertSee('Client Test');
        });
    }

    /**
     * Test de création d'intervention
     */
    public function test_create_intervention()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions/create')
                    ->assertSee('Nouvelle intervention')
                    ->select('client_id', '1')
                    ->type('device_type', 'Tablette')
                    ->type('description', 'Problème de charge')
                    ->select('priority', 'medium')
                    ->select('status', 'nouvelle_demande')
                    ->press('Créer l\'intervention')
                    ->assertSee('Intervention créée avec succès');
        });
    }

    /**
     * Test de gestion des clients
     */
    public function test_client_management()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/clients')
                    ->assertSee('Clients')
                    ->assertSee('Client Test 1')
                    ->assertSee('Client Test 2')
                    ->clickLink('Voir', 'a[href*="/clients/"]')
                    ->assertSee('Profil client')
                    ->assertSee('Historique des interventions');
        });
    }

    /**
     * Test de création de client
     */
    public function test_create_client()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/clients/create')
                    ->assertSee('Nouveau client')
                    ->type('name', 'Nouveau Client')
                    ->type('email', 'nouveau@test.com')
                    ->type('phone', '01 11 22 33 44')
                    ->press('Créer le client')
                    ->assertSee('Client créé avec succès');
        });
    }

    /**
     * Test d'export CSV
     */
    public function test_export_csv()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/dashboard/export')
                    ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        });
    }
}
