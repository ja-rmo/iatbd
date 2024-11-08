<?php

namespace Tests\Feature;

use Database\Factories\ProfileFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\House;
use App\Models\Pet;
use App\Models\HousePhoto;
use App\Models\PetPhoto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class FileTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_house_can_handle_photos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $house = House::factory()->make();
        $house->user_id = $user->id;
        $house->save();

        // create a photo for the house, no factory
        $photo = new HousePhoto();
        $photo->house_id = $house->id;
        $photo->url = UploadedFile::fake()->image('photo.jpg');
        $photo->save();

        $this->assertDatabaseHas('house_photos', ['house_id' => $house->id, 'url' => $photo->url]);
    }
    // delete a photo
    public function test_house_can_delete_photos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $house = House::factory()->make();
        $house->user_id = $user->id;
        $house->save();

        // create a photo for the house, no factory
        $photo = new HousePhoto();
        $photo->house_id = $house->id;
        $photo->url = UploadedFile::fake()->image('photo.jpg');
        $photo->save();

        $photo->delete();

        $this->assertDatabaseMissing('house_photos', ['house_id' => $house->id, 'url' => $photo->url]);
    }

    // test if house can handle multiple photos
    public function test_house_can_handle_multiple_photos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $house = House::factory()->make();
        $house->user_id = $user->id;
        $house->save();

        $photos = [];
        for ($i = 0; $i < 3; $i++) {
            $photo = new HousePhoto();
            $photo->house_id = $house->id;
            $photo->url = UploadedFile::fake()->image('photo.jpg');
            $photo->save();
            $photos[] = $photo;
        }

        $this->assertDatabaseCount('house_photos', 3);
    }

    // test if pet can handle photos
    public function test_pet_can_handle_photos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pet = Pet::factory()->make();
        $pet->user_id = $user->id;
        $pet->save();

        // create a photo for the pet, no factory
        $photo = new PetPhoto();
        $photo->pet_id = $pet->id;
        $photo->url = UploadedFile::fake()->image('photo.jpg');
        $photo->save();

        $this->assertDatabaseHas('pet_photos', ['pet_id' => $pet->id, 'url' => $photo->url]);
    }

    // delete a photo
    public function test_pet_can_delete_photos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pet = Pet::factory()->make();
        $pet->user_id = $user->id;
        $pet->save();

        // create a photo for the pet, no factory
        $photo = new PetPhoto();
        $photo->pet_id = $pet->id;
        $photo->url = UploadedFile::fake()->image('photo.jpg');
        $photo->save();

        $photo->delete();

        $this->assertDatabaseMissing('pet_photos', ['pet_id' => $pet->id, 'url' => $photo->url]);
    }

    // test if pet can handle multiple photos
    public function test_pet_can_handle_multiple_photos(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pet = Pet::factory()->make();
        $pet->user_id = $user->id;
        $pet->save();
        Storage::fake('public');

        $photos = [];
        for ($i = 0; $i < 3; $i++) {
            $photo = new PetPhoto();
            $photo->pet_id = $pet->id;
            $photo->url = UploadedFile::fake()->image('photo.jpg');
            $photo->save();
            $photos[] = $photo;
        }


        $this->assertDatabaseCount('pet_photos', 3);
    }

    // test if profile can handle photo
    public function test_profile_can_handle_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $profile = Profile::factory()->make(['user_id' => $user->id]);
        $profile->save();

        $this->actingAs($user);

        $photo = UploadedFile::fake()->image('photo.jpg');
        $bio = $this->faker->paragraph();

        $response = $this->put('/profile', ['photo' => $photo, 'bio' => $bio]);

        $response->assertStatus(302);

        // Assert the file was stored...
        // Storage::disk('public')->assertExists('profile-photos/' . $photo->hashName());

        // Assert the database has the expected data...
        $this->assertDatabaseHas('profiles', ['id' => $profile->id, 'user_id' => $user->id, 'photo' => 'profile-photos/' . $photo->hashName(), 'bio' => $bio]);
    }
}
