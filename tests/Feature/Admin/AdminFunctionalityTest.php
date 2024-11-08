<?php

namespace Tests\Feature\Admin;
use App\Models\User;
use App\Models\SittingRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test of een admin een gebruiker kan blokkeren.
     */
    // public function test_admin_can_block_user()
    // {
    //     // Maak een admin gebruiker aan
    //     $admin = User::factory()->create(['is_admin' => true]);

    //     // Maak een normale gebruiker aan
    //     $user = User::factory()->create();

    //     // Zorg ervoor dat de admin is ingelogd
    //     $this->actingAs($admin);

    //     // Roep de route aan om de gebruiker te blokkeren
    //     $response = $this->post(route('admin.blockUser', $user->id));

    //     // Controleer of de gebruiker nu geblokkeerd is
    //     $user->refresh();
    //     $this->assertTrue($user->is_blocked);

    //     // Controleer of de response een redirect of succes status bevat
    //     $response->assertStatus(302)->assertSessionHas('status', 'User blocked successfully');
    // }

    // /**
    //  * Test of een admin een oppasaanvraag kan verwijderen.
    //  */
    // public function test_admin_can_delete_pet_sitting_request()
    // {
    //     // Maak een admin gebruiker aan
    //     $admin = User::factory()->create(['is_admin' => true]);

    //     // Maak een oppasaanvraag aan
    //     $sittingRequest = SittingRequest::factory()->create();

    //     // Zorg ervoor dat de admin is ingelogd
    //     $this->actingAs($admin);

    //     // Roep de route aan om de oppasaanvraag te verwijderen
    //     $response = $this->delete(route('admin.deleteSittingRequest', $sittingRequest->id));

    //     // Controleer of de oppasaanvraag is verwijderd
    //     $this->assertDatabaseMissing('pet_sitting_requests', ['id' => $sittingRequest->id]);

    //     // Controleer of de response een redirect of succes status bevat
    //     $response->assertStatus(302)->assertSessionHas('status', 'Pet sitting request deleted successfully');
    // }
}