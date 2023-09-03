<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'First Lesson Watched',
                'points' => 1,
                'model_type' => 'App\Models\Lesson',
            ],
            [
                'name' => '5 Lessons Watched',
                'points' => 5,
                'model_type' => 'App\Models\Lesson',
            ],
            [
                'name' => '10 Lessons Watched',
                'points' => 10,
                'model_type' => 'App\Models\Lesson',
            ],
            [
                'name' => '25 Lessons Watched',
                'points' => 25,
                'model_type' => 'App\Models\Lesson',
            ],
            [
                'name' => '50 Lessons Watched',
                'points' => 50,
                'model_type' => 'App\Models\Lesson',
            ],

            [
                'name' => 'First Comment Written',
                'points' => 1,
                'model_type' => 'App\Models\Comment',
            ],
            [
                'name' => '3 Comments Written',
                'points' => 3,
                'model_type' => 'App\Models\Comment',
            ],
            [
                'name' => '5 Comments Written',
                'points' => 5,
                'model_type' => 'App\Models\Comment',
            ],
            [
                'name' => '10 Comments Written',
                'points' => 10,
                'model_type' => 'App\Models\Comment',
            ],
            [
                'name' => '20 Comments Written',
                'points' => 20,
                'model_type' => 'App\Models\Comment',
            ],
            
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
