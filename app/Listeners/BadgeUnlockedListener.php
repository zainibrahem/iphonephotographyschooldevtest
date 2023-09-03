<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeUnlockedListener
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
    public function handle(BadgeUnlocked $event): void
    {
        // here is the payload of  BadgeUnlocked Event and we can manipulate the data received or do what ever we want with it
        // dd([
        //     $event->badgeName,
        //     $event->user->name
        // ]);
    }
}
