<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use App\Models\Kitchen;
use App\Models\UserKitchen;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Drop all tables to avoid unique constraint violations
        DB::table('users')->delete();
        DB::table('kitchens')->delete();
        DB::table('items')->delete(); // Corrected table name
        DB::table('user_kitchen')->delete();

        // Ensure kitchens are created first
        Kitchen::factory(10)->create();

        // make a test user, with this email test@email.dk and password 12345678 and assign a kitchen
        $testUser = User::firstOrCreate([
            'email' => 'test@email.dk',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('12345678'),
            'phone_number' => '12345678',
        ]);
        
        // create 10 users
        User::factory(10)->create();
        
        // For each kitchen, create 10 items
        Kitchen::all()->each(function ($kitchen) {
            // Run 10 times so that each kitchen has 10 items
            for ($i = 0; $i < 10; $i++) {
                $user_id = User::inRandomOrder()->first()->id;
                $kitchen_id = $kitchen->id;

                Item::factory()->create([
                    'kitchen_id' => $kitchen_id,
                    // Assign a random user to each item
                    'user_id' => $user_id,
                ]);
                //assign the user to the kitchen in the pivot table user_kitchen uniquely
                UserKitchen::firstOrCreate([
                    'user_id' => $user_id,
                    'kitchen_id' => $kitchen_id,
                ], [
                    'is_owner' => false,
                ]);        
            }

            // update a random user to each kitchen as a owner in the pivot table user_kitchen
            UserKitchen::where('kitchen_id', $kitchen->id)->inRandomOrder()->first()->update([
                'is_owner' => true,
            ]);

        });
    }
}
