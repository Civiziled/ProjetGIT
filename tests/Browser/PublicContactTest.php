<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PublicContactTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test de soumission du formulaire de contact public
     */
    public function test_public_contact_form_submission()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Atelier 404')
                    ->assertSee('Demander une réparation')
                    ->scrollTo('#contact')
                    ->type('name', 'Test Client')
                    ->type('email', 'test@example.com')
                    ->type('phone', '01 23 45 67 89')
                    ->select('device_type', 'Ordinateur portable')
                    ->type('description', 'Mon ordinateur ne démarre plus. Écran noir au démarrage.')
                    ->press('Envoyer la demande')
                    ->assertSee('Votre demande a été envoyée avec succès')
                    ->assertPathIs('/');
        });
    }

    /**
     * Test de validation du formulaire de contact
     */
    public function test_public_contact_form_validation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->scrollTo('#contact')
                    ->press('Envoyer la demande')
                    ->assertSee('Le champ nom complet est obligatoire')
                    ->assertSee('Le champ email est obligatoire')
                    ->assertSee('Le champ téléphone est obligatoire')
                    ->assertSee('Le champ type d\'appareil est obligatoire')
                    ->assertSee('Le champ description du problème est obligatoire');
        });
    }

    /**
     * Test de création automatique de client et intervention
     */
    public function test_automatic_client_and_intervention_creation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->scrollTo('#contact')
                    ->type('name', 'Nouveau Client')
                    ->type('email', 'nouveau@example.com')
                    ->type('phone', '01 98 76 54 32')
                    ->select('device_type', 'Smartphone')
                    ->type('description', 'Écran fissuré après une chute')
                    ->press('Envoyer la demande')
                    ->assertSee('Votre demande a été envoyée avec succès');

            // Vérifier que le client et l'intervention ont été créés
            $this->assertDatabaseHas('clients', [
                'name' => 'Nouveau Client',
                'email' => 'nouveau@example.com',
                'phone' => '01 98 76 54 32'
            ]);

            $this->assertDatabaseHas('interventions', [
                'device_type' => 'Smartphone',
                'description' => 'Écran fissuré après une chute',
                'status' => 'nouvelle_demande',
                'priority' => 'medium'
            ]);
        });
    }
}
