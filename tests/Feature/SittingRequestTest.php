<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pet;
use App\Models\SittingRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SittingRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test het aanmaken van een oppasaanvraag.
     */
    public function test_create_sittingrequest()
    {
        // Maak een gebruiker en een huisdier aan
        $owner = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);

        // Log de gebruiker in
        $this->actingAs($owner);

        // Simuleer een POST verzoek om een oppasaanvraag aan te maken
        $response = $this->post('/sittingrequests', [
            'pet_id' => $pet->id,
            'owner_id' => $owner->id,
            'start_date' => '2024-10-01',
            'end_date' => '2024-10-10',
            'status' => 'open',
            'message' => 'Ik zoek een oppas voor mijn hond.',
            'rate' => 15.00,
        ]);

        // Controleer of de oppasaanvraag is aangemaakt
        $response->assertStatus(302);
        $this->assertDatabaseHas('pet_sitting_requests', [
            'pet_id' => $pet->id,
            'owner_id' => $owner->id,
            'start_date' => '2024-10-01',
            'end_date' => '2024-10-10',
            'status' => 'open',
            'message' => 'Ik zoek een oppas voor mijn hond.',
            'rate' => 15.00,
        ]);
    }

    public function test_owner_can_update_sittingrequest()
    {
        // Maak een gebruiker en een oppasaanvraag aan
        $owner = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);
        $sittingRequest = SittingRequest::factory()->create(['owner_id' => $owner->id, 'pet_id' => $pet->id, 'status' => 'open']);

        // Log de gebruiker in
        $this->actingAs($owner);

        // Simuleer een PUT verzoek om de oppasaanvraag te bewerken
        $response = $this->put("/sittingrequests/{$sittingRequest->id}", [
            'pet_id' => $pet->id,
            'start_date' => '2024-10-01',
            'end_date' => '2024-10-10',
            'message' => 'Ik zoek een oppas voor mijn hond.',
            'rate' => 15.00,
        ]);

        // Controleer of de oppasaanvraag is bijgewerkt
        $response->assertStatus(302);
        $this->assertDatabaseHas('pet_sitting_requests', [
            'id' => $sittingRequest->id,
            'pet_id' => $pet->id,
            'start_date' => '2024-10-01',
            'end_date' => '2024-10-10',
            'message' => 'Ik zoek een oppas voor mijn hond.',
            'rate' => 15.00,
        ]);
    }

    /**
     * Test het bewerken van een oppasaanvraag.
     */
    public function test_owner_can_accept_sittingrequest()
    {
        // Maak een gebruiker en een oppasaanvraag aan
        $owner = User::factory()->create();
        $sitter = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);
        $sittingRequest = SittingRequest::factory()->create(['owner_id' => $owner->id, 'sitter_id' => $sitter->id, 'pet_id' => $pet->id, 'status' => 'pending']);

        // Log de eigenaar in
        $this->actingAs($owner);

        // Simuleer een PUT verzoek om de oppasaanvraag te bewerken
        $response = $this->put("/sittingrequests/{$sittingRequest->id}", [
            'status' => 'accepted',
            'message' => 'De oppasaanvraag is aangenomen.',
        ]);

        // Controleer of de oppasaanvraag is bijgewerkt
        $response->assertStatus(302);
        $this->assertDatabaseHas('pet_sitting_requests', [
            'id' => $sittingRequest->id,
            'status' => 'accepted',
            'message' => 'De oppasaanvraag is aangenomen.',
        ]);
    }

    /**
     * Test het afwijzen van een oppasaanvraag.
     */
    public function test_owner_can_decline_sittingrequest()
    {
        // Maak een gebruiker en een oppasaanvraag aan
        $owner = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);
        $sittingRequest = SittingRequest::factory()->create(['owner_id' => $owner->id, 'pet_id' => $pet->id, 'status' => 'pending']);

        // Log de eigenaar in
        $this->actingAs($owner);

        // Simuleer een PUT verzoek om de oppasaanvraag te bewerken
        $response = $this->put("/sittingrequests/{$sittingRequest->id}", [
            'message' => 'De oppasaanvraag is afgewezen.', // Stel dat de eigenaar een bericht kan toevoegen    
            'status' => 'rejected',
        ]);

        // Controleer of de oppasaanvraag is bijgewerkt
        $response->assertStatus(302);
        $this->assertDatabaseHas('pet_sitting_requests', [
            'id' => $sittingRequest->id,
            'status' => 'rejected',
        ]);
    }


    /**
     * Test het bewerken van een oppasaanvraag door een oppasser.
     */
    public function test_sitter_can_update_sittingrequest()
    {
        // Maak een eigenaar en een oppasser aan
        $sitter = User::factory()->create();
        $owner = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);
        $sittingRequest = SittingRequest::factory()->create(['sitter_id' => $sitter->id, 'pet_id' => $pet->id, 'owner_id' => $owner->id, 'status' => 'open']);

        // Log de oppasser in
        $this->actingAs($sitter);

        // Simuleer een PUT verzoek om de oppasaanvraag te bewerken
        $response = $this->put("/sittingrequests/{$sittingRequest->id}", [
            'sitter_id' => $sitter->id,
            'status' => 'pending', // Stel dat de oppasser de status kan bijwerken
        ]);

        // Controleer of de oppasaanvraag is bijgewerkt
        $response->assertStatus(302);
        $this->assertDatabaseHas('pet_sitting_requests', [
            'id' => $sittingRequest->id,
            'sitter_id' => $sitter->id,
            'status' => 'pending',
        ]);
    }

    /**
     * Test het verwijderen van een oppasaanvraag.
     */
    public function test_delete_sittingrequest()
    {
        // Maak een gebruiker en een oppasaanvraag aan
        $user = User::factory()->create();
        $sittingRequest = SittingRequest::factory()->create(['owner_id' => $user->id]);

        // Log de gebruiker in
        $this->actingAs($user);

        // Simuleer een DELETE verzoek om de oppasaanvraag te verwijderen
        $response = $this->delete("/sittingrequests/{$sittingRequest->id}");
        


        // Controleer of de oppasaanvraag is verwijderd
        $response->assertStatus(302);
        $this->assertDatabaseMissing('pet_sitting_requests', [
            'id' => $sittingRequest->id,
        ]);
    }

    /**
     * Test het bekijken van een oppasaanvraag.
     */
    public function test_view_sittingrequest()
    {
        // Maak een gebruiker en een oppasaanvraag aan
        $owner = User::factory()->create();
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $owner->id]);
        $sittingRequest = SittingRequest::factory()->create(['owner_id' => $owner->id, 'pet_id' => $pet->id]);

        $this->actingAs($user);
        // Simuleer een GET verzoek om de oppasaanvraag te bekijken
        $response = $this->get("/sittingrequests/{$sittingRequest->id}");

        // Controleer of de juiste informatie wordt weergegeven
        $response->assertStatus(200);
        $response->assertSee($sittingRequest->pet->name);
        $response->assertSee($sittingRequest->owner->name);
        $response->assertSee($sittingRequest->start_date);
        $response->assertSee($sittingRequest->end_date);
        $response->assertSee($sittingRequest->status);
        $response->assertSee($sittingRequest->message);
        $response->assertSee($sittingRequest->rate);
    }
}