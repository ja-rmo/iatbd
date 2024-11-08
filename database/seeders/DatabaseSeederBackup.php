<?php
//
//namespace Database\Seeders;
//
//use App\Models\User;
//use App\Models\Profile;
//use App\Models\House;
//use App\Models\Pet;
//use App\Models\Review;
//use App\Models\SittingRequest;
//use App\Models\Application;
//// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;
//use Faker\Factory as Faker;
//
//class DatabaseSeederBackup extends Seeder
//{
//    /**
//     * Seed the application's database.
//     */
//    public function run(): void
//    {
//        $faker = Faker::create();
//        // create an admin user with simple password for testing
//        User::factory()->create([
//            'name' => 'Admin',
//            'email' => 'admin@example.com',
//            'password' => bcrypt('password'),
//            'role' => 'admin',
//        ]);
//
//        // Create a sitter user with a profile and house
//        $sitter = User::factory()->create([
//            'name' => 'Sitter',
//            'email' => 'sitter@example.com',
//            'password' => bcrypt('password'),
//        ]);
//        Profile::factory()->create(['user_id' => $sitter->id, 'role' => 'sitter']);
//        House::factory()->create(['user_id' => $sitter->id]);
//
//        // Create an owner user with a profile and pets
//        $owner = User::factory()->create([
//            'name' => 'Owner',
//            'email' => 'owner@example.com',
//            'password' => bcrypt('password'),
//        ]);
//
//        Profile::factory()->create(['user_id' => $owner->id, 'role' => 'owner']);
//        $pets = Pet::factory(2)->create(['owner_id' => $owner->id]);
//
//        // Create pet sitting requests for each pet
//        $pets->first(function ($pet) use ($faker, $sitter) {
//            $sittingRequest = SittingRequest::factory()->create([
//                'pet_id' => $pet->id,
//                'start_date' => $faker->dateTimeBetween('-2 weeks', '-1 weeks'),
//                'end_date' => $faker->dateTimeBetween('-1 weeks', '-1 days'),
//            ]);
//            $sittingRequest->each(function ($sittingRequest) use ($faker, $sitter) {
//                Application::factory()->create([
//                    'sitting_request_id' => $sittingRequest->id,
//                    'sitter_id' => $sitter->id,
//                    'status' => 'accepted',
//                ]);
//            });
//        });
//
//        $pet = $pets->last();
//        $sittingRequest = SittingRequest::factory()->create(['pet_id' => $pet->id]);
//        Application::factory()->create(['sitter_id' => $sitter->id, 'sitting_request_id' => $sittingRequest->id, 'status' => 'pending']);
//
//
//        $owners = User::factory(5)->create();
//        $sitters = User::factory(5)->create();
//
//        $owners->each(function ($owner) use ($faker, $sitters) {
//            Profile::factory()->create(['user_id' => $owner->id, 'role' => 'owner']);
//            $pets = Pet::factory(2)->create(['owner_id' => $owner->id]);
//            $pets->first(function ($pet) use ($faker, $sitters) {
//                $sittingRequest = SittingRequest::factory()->create([
//                    'pet_id' => $pet->id,
//                    'start_date' => $faker->dateTimeBetween('-2 weeks', '-1 weeks'),
//                    'end_date' => $faker->dateTimeBetween('-1 weeks', '-1 days')
//                ]);
//                $sittingRequest->each(function ($sittingRequest) use ($sitters) {
//                    $application = Application::factory()->create([
//                        'sitting_request_id' => $sittingRequest->id,
//                        'sitter_id' => $sitters->random()->id,
//                        'status' => 'accepted'
//                    ]);
//                    Review::factory()->create(['application_id' => $application->id]);
//                });
//            });
//            $pets->last(function ($pet) use ($sitters) {
//                $sittingRequest = SittingRequest::factory(2)->create(['pet_id' => $pet->id]);
//                $sittingRequest->first(function ($sittingRequest) use ($sitters) {
//                    Application::factory()->create(['sitting_request_id' => $sittingRequest->id, 'sitter_id' => $sitters->random()->id]);
//                });
//            });
//        });
//
//        $sitters->each(function ($sitter) {
//            Profile::factory()->create(['user_id' => $sitter->id, 'role' => 'sitter']);
//            House::factory()->create(['user_id' => $sitter->id]);
//        });
//    }
//}
