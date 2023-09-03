<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event): void
    {
        // here is the payload of  AchievementUnlocked Event and we can manipulate the data received or do what ever we want with it
        // dd([
        //     $event->achievementName,
        //     $event->user->name
        // ]);
    }
}
