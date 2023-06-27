<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\News;
use App\Models\User;
use App\Models\Feedback;
use App\Models\UserSubs;
use App\Models\Favourite;
use App\Models\SurveyResult;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UserSubsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        

        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            UserSubsSeeder::class,
            NewsSeeder::class
        ]);

        Feedback::factory(20)->create();
        Favourite::factory(20)->create();
        SurveyResult::factory(100)->create();
    }
}
