<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Client;
use App\Models\Intervention;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchAndFilterTest extends DuskTestCase
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

        // Créer des techniciens
        $this->technician1 = User::create([
            'name' => 'Technicien 1',
            'email' => 'tech1@test.com',
            'password' => bcrypt('password'),
            'role' => 'technicien',
            'email_verified_at' => now(),
        ]);

        $this->technician2 = User::create([
            'name' => 'Technicien 2',
            'email' => 'tech2@test.com',
            'password' => bcrypt('password'),
            'role' => 'technicien',
            'email_verified_at' => now(),
        ]);

        // Créer des données de test
        $this->createTestData();
    }

    private function createTestData()
    {
        // Créer des clients
        $client1 = Client::create([
            'name' => 'Client Ordinateur',
            'email' => 'client1@test.com',
            'phone' => '01 23 45 67 89',
        ]);

        $client2 = Client::create([
            'name' => 'Client Smartphone',
            'email' => 'client2@test.com',
            'phone' => '01 98 76 54 32',
        ]);

        // Créer des interventions avec différents statuts et priorités
        Intervention::create([
            'client_id' => $client1->id,
            'assigned_technician_id' => $this->technician1->id,
            'description' => 'Problème de démarrage ordinateur',
            'device_type' => 'Ordinateur portable',
            'priority' => 'high',
            'status' => 'diagnostic',
        ]);

        Intervention::create([
            'client_id' => $client2->id,
            'assigned_technician_id' => $this->technician2->id,
            'description' => 'Écran smartphone fissuré',
            'device_type' => 'Smartphone',
            'priority' => 'medium',
            'status' => 'en_reparation',
        ]);

        Intervention::create([
            'client_id' => $client1->id,
            'description' => 'Tablette qui ne charge plus',
            'device_type' => 'Tablette',
            'priority' => 'low',
            'status' => 'nouvelle_demande',
        ]);

        Intervention::create([
            'client_id' => $client2->id,
            'assigned_technician_id' => $this->technician1->id,
            'description' => 'Ordinateur réparé avec succès',
            'device_type' => 'Ordinateur de bureau',
            'priority' => 'high',
            'status' => 'termine',
        ]);
    }

    /**
     * Test de recherche par nom de client
     */
    public function test_search_by_client_name()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->type('search', 'Client Ordinateur')
                    ->press('Filtrer')
                    ->assertSee('Client Ordinateur')
                    ->assertDontSee('Client Smartphone');
        });
    }

    /**
     * Test de recherche par type d'appareil
     */
    public function test_search_by_device_type()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->type('search', 'Smartphone')
                    ->press('Filtrer')
                    ->assertSee('Smartphone')
                    ->assertDontSee('Ordinateur portable');
        });
    }

    /**
     * Test de filtrage par statut
     */
    public function test_filter_by_status()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->select('status', 'diagnostic')
                    ->press('Filtrer')
                    ->assertSee('Diagnostic')
                    ->assertDontSee('Nouvelle demande');
        });
    }

    /**
     * Test de filtrage par priorité
     */
    public function test_filter_by_priority()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->select('priority', 'high')
                    ->press('Filtrer')
                    ->assertSee('Élevée')
                    ->assertDontSee('Moyenne');
        });
    }

    /**
     * Test de filtrage par technicien
     */
    public function test_filter_by_technician()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->select('technician', $this->technician1->id)
                    ->press('Filtrer')
                    ->assertSee('Technicien 1')
                    ->assertDontSee('Technicien 2');
        });
    }

    /**
     * Test de filtrage combiné
     */
    public function test_combined_filters()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->type('search', 'Ordinateur')
                    ->select('status', 'diagnostic')
                    ->select('priority', 'high')
                    ->press('Filtrer')
                    ->assertSee('Client Ordinateur')
                    ->assertSee('Diagnostic')
                    ->assertSee('Élevée');
        });
    }

    /**
     * Test de recherche côté technicien
     */
    public function test_technician_search()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->technician1)
                    ->visit('/interventions')
                    ->type('search', 'Ordinateur')
                    ->press('Filtrer')
                    ->assertSee('Client Ordinateur')
                    ->assertSee('Client Smartphone') // Technicien 1 a les deux
                    ->assertDontSee('Tablette'); // Non assignée
        });
    }

    /**
     * Test de recherche vide
     */
    public function test_empty_search()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->type('search', 'Inexistant')
                    ->press('Filtrer')
                    ->assertSee('Aucune intervention');
        });
    }

    /**
     * Test de réinitialisation des filtres
     */
    public function test_reset_filters()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit('/interventions')
                    ->type('search', 'Test')
                    ->select('status', 'diagnostic')
                    ->press('Filtrer')
                    ->assertSee('Aucune intervention')
                    ->visit('/interventions') // Retour à la liste sans filtres
                    ->assertSee('Client Ordinateur')
                    ->assertSee('Client Smartphone');
        });
    }
}
