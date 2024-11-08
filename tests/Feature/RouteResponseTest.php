<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\House;
use App\Models\Pet;
use App\Models\SittingRequest;

class RouteResponseTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_home_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_dashboard_route()
    {
        Profile::create([
            'user_id' => $this->user->id,
            'bio' => 'This is a test bio',
            'role' => 'owner'
        ]);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_welcome_route()
    {
        $response = $this->get('/welcome');
        $response->assertStatus(200);
    }

    public function test_houses_routes()
    {
        $response = $this->get('/houses/create');
        $response->assertStatus(200);

        $house = House::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get('/houses/1');
        $response->assertStatus(200);

        $response = $this->get('/houses/1/edit');
        $response->assertStatus(200);
    }

    public function test_pets_routes()
    {
        $response = $this->get('/pets');
        $response->assertStatus(200);

        $response = $this->get('/pets/create');
        $response->assertStatus(200);
        
        $pet = Pet::factory()->create(['owner_id' => $this->user->id]);
        $response = $this->get('/pets/1');
        $response->assertStatus(200);

        $response = $this->get('/pets/1/edit');
        $response->assertStatus(200);
    }

    public function test_sittingrequests_routes()
    {
        $response = $this->get('/sittingrequests/create');
        $response->assertStatus(200);

        $pet = Pet::factory()->create(['owner_id' => $this->user->id]);
        $sittingRequest = SittingRequest::factory()->create(['pet_id' => $pet->id]);

        $response = $this->get('/sittingrequests/1');
        $response->assertStatus(200);

        $response = $this->get('/sittingrequests/1/edit');
        $response->assertStatus(200);
    }
}