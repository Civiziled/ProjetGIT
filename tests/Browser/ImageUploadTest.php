<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Client;
use App\Models\Intervention;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadTest extends DuskTestCase
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

        // Créer une intervention
        $this->intervention = Intervention::create([
            'client_id' => $client->id,
            'assigned_technician_id' => $this->technician->id,
            'description' => 'Problème de démarrage',
            'device_type' => 'Ordinateur portable',
            'priority' => 'high',
            'status' => 'diagnostic',
        ]);
    }

    /**
     * Test d'upload d'images par admin
     */
    public function test_admin_can_upload_images()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit("/interventions/{$this->intervention->id}/edit")
                    ->assertSee('Modifier l\'intervention')
                    ->attach('images[]', __DIR__ . '/../fixtures/test-image.jpg')
                    ->press('Mettre à jour')
                    ->assertSee('Intervention mise à jour avec succès');
        });
    }

    /**
     * Test d'upload d'images par technicien assigné
     */
    public function test_technician_can_upload_images()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->technician)
                    ->visit("/interventions/{$this->intervention->id}/edit")
                    ->assertSee('Modifier l\'intervention')
                    ->attach('images[]', __DIR__ . '/../fixtures/test-image.jpg')
                    ->press('Mettre à jour')
                    ->assertSee('Intervention mise à jour avec succès');
        });
    }

    /**
     * Test de validation des types de fichiers
     */
    public function test_image_validation()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit("/interventions/{$this->intervention->id}/edit")
                    ->attach('images[]', __DIR__ . '/../fixtures/test-document.pdf')
                    ->press('Mettre à jour')
                    ->assertSee('Le champ images.0 doit être une image');
        });
    }

    /**
     * Test de validation de la taille des fichiers
     */
    public function test_image_size_validation()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit("/interventions/{$this->intervention->id}/edit")
                    ->attach('images[]', __DIR__ . '/../fixtures/large-image.jpg')
                    ->press('Mettre à jour')
                    ->assertSee('Le champ images.0 ne doit pas dépasser 5120 kilo-octets');
        });
    }

    /**
     * Test d'affichage des images
     */
    public function test_display_uploaded_images()
    {
        // Créer une image de test
        $image = $this->intervention->images()->create([
            'filename' => 'test-image.jpg',
            'original_name' => 'test-image.jpg',
            'path' => 'interventions/1/test-image.jpg',
            'size' => 1024,
            'mime_type' => 'image/jpeg',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit("/interventions/{$this->intervention->id}")
                    ->assertSee('Images')
                    ->assertSee('1 image(s)')
                    ->assertPresent('img[src*="test-image.jpg"]');
        });
    }

    /**
     * Test de suppression d'images
     */
    public function test_delete_image()
    {
        // Créer une image de test
        $image = $this->intervention->images()->create([
            'filename' => 'test-image.jpg',
            'original_name' => 'test-image.jpg',
            'path' => 'interventions/1/test-image.jpg',
            'size' => 1024,
            'mime_type' => 'image/jpeg',
        ]);

        $this->browse(function (Browser $browser) use ($image) {
            $browser->loginAs($this->admin)
                    ->visit("/interventions/{$this->intervention->id}")
                    ->assertSee('Images')
                    ->click('button[type="submit"]')
                    ->acceptDialog()
                    ->assertSee('Image supprimée avec succès');
        });
    }

    /**
     * Test de génération de thumbnails
     */
    public function test_thumbnail_generation()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                    ->visit("/interventions/{$this->intervention->id}/edit")
                    ->attach('images[]', __DIR__ . '/../fixtures/test-image.jpg')
                    ->press('Mettre à jour')
                    ->assertSee('Intervention mise à jour avec succès');

            // Vérifier que le thumbnail a été créé
            $this->assertTrue(
                Storage::disk('public')->exists('interventions/1/thumbnails/test-image_thumb.jpg')
            );
        });
    }
}
