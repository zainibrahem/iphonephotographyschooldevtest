<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Beginner',
                'required_achievements' => 0,
            ],
            [
                'name' => 'Intermediate',
                'required_achievements' => 4,
            ],
            [
                'name' => 'Advanced',
                'required_achievements' => 8,
            ],
            [
                'name' => 'Master',
                'required_achievements' => 10,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
