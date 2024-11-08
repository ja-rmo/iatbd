<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\House;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HouseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test het aanmaken van een huis.
     */
    public function test_create_house()
    {
        // Maak een gebruiker aan
        $user = User::factory()->create();

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een POST verzoek om een huis aan te maken
        $response = $this->post('/houses', [
            'user_id' => $user->id,
            'address' => 'Straatnaam 123',
            'description' => 'Een beschrijving van het huis',
        ]);

        // Controleer of het huis is aangemaakt
        $response->assertStatus(302);
        $this->assertDatabaseHas('houses', [
            'user_id' => $user->id,
            'address' => 'Straatnaam 123',
            'description' => 'Een beschrijving van het huis',
        ]);
    }

    /**
     * Test het bewerken van een huis.
     */
    public function test_update_house()
    {
        // Maak een gebruiker en een huis aan
        $user = User::factory()->create();
        $house = House::factory()->create(['user_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een PUT verzoek om het huis te bewerken
        $response = $this->put("/houses/{$house->id}", [
            'address' => 'Nieuwe Straatnaam 456',
            'description' => 'Een nieuwe beschrijving van het huis',
        ]);

        // Controleer of het huis is bijgewerkt
        $response->assertStatus(302);
        $this->assertDatabaseHas('houses', [
            'id' => $house->id,
            'address' => 'Nieuwe Straatnaam 456',
            'description' => 'Een nieuwe beschrijving van het huis',
        ]);
    }
    /**
     * Test het bekijken van een huis.
     */
    public function test_view_house()
    {
        // Maak een gebruiker en een huis aan
        $user = User::factory()->create();
        $house = House::factory()->create(['user_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een GET verzoek om het huis te bekijken
        $response = $this->get("/houses/{$house->id}");

        // Controleer of de juiste informatie wordt weergegeven
        $response->assertStatus(200);
        $response->assertSee($house->user->name);
        $response->assertSee($house->address);
        $response->assertSee($house->description);
    }
    /**
     * Test het verwijderen van een huis.
     */
    public function test_delete_house()
    {
        // Maak een gebruiker en een huis aan
        $user = User::factory()->create();
        $house = House::factory()->create(['user_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een DELETE verzoek om het huis te verwijderen
        $response = $this->delete("/houses/{$house->id}");

        // Controleer of het huis is verwijderd
        $response->assertStatus(302);
        $this->assertDatabaseMissing('houses', [
            'id' => $house->id,
        ]);
    }
}