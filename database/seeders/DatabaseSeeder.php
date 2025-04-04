<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->make()->each(function ($user) {
        //     $user->created_at = now()->subDays(rand(1, 365)); 
        //     $user->save();
        
        //     // Create random number of posts for each user (between 1 and 10)
        //     Post::factory(rand(1, 10))->create([
        //         'user_id' => $user->id,
        //     ]);
        // });
        

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::create([
            "name" => "Test User",
            "email"=> "test@test.com",
            "password"=> bcrypt("test")
        ]);

        $tenant =  Tenant::create([
            "name" => "My Tenant",
            "email" =>"tenant@teant.com",
            "contact"=>"1234567890"
        ]);

        $tenant->users()->attach($user);
    }
}
