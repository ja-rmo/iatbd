<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test het aanmaken van een huisdier.
     */
    public function test_create_pet()
    {
        // Maak een gebruiker aan
        $user = User::factory()->create();

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een POST verzoek om een huisdier aan te maken
        $response = $this->post('/pets', [
            'name' => 'Fido',
            'species' => 'Hond',
            'description' => 'Een lieve hond',
            ]
        );

        // Controleer of het huisdier is aangemaakt
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('pets', [
            'name' => 'Fido',
            'species' => 'Hond',
            'description' => 'Een lieve hond',
        ]);
    }

    /**
     * Test het bewerken van een huisdier.
     */
    public function test_update_pet()
    {
        // Maak een gebruiker en een huisdier aan
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een PUT verzoek om het huisdier te bewerken
        $response = $this->put("/pets/{$pet->id}", [
            'name' => 'Rex',
            'species' => 'Kat',
            'description' => 'Een lieve kat',
        ]);

        // Controleer of het huisdier is bijgewerkt
        $response->assertStatus(302);
        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'name' => 'Rex',
            'species' => 'Kat',
            'description' => 'Een lieve kat',
        ]);

        // Controleer of de nieuwe foto's zijn opgeslagen
    }

    /**
     * Test het bekijken van een huisdier.
     */
    public function test_view_pet()
    {
        // Maak een gebruiker en een huisdier aan
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een GET verzoek om het huisdier te bekijken
        $response = $this->get("/pets/{$pet->id}");

        // Controleer of de juiste informatie wordt weergegeven
        $response->assertStatus(200);
        $response->assertSee($pet->name);
        $response->assertSee($pet->species);
        $response->assertSee($pet->description);

    }

    /**
     * Test het verwijderen van een huisdier.
     */
    public function test_delete_pet()
    {
        // Maak een gebruiker en een huisdier aan
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een DELETE verzoek om het huisdier te verwijderen
        $response = $this->delete("/pets/{$pet->id}");

        // Controleer of het huisdier is verwijderd
        $response->assertStatus(302);
        $this->assertDatabaseMissing('pets', [
            'id' => $pet->id,
        ]);

    }

}