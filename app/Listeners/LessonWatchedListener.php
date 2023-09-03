<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Services\UnlockAchievement;
use App\Services\UnlockAchievementsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LessonWatchedListener
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
    public function handle(LessonWatched $event)
    {
        $user = $event->user;

        // Check if the user has already unlocked the achievement for watching this lesson.
        $achievement = Achievement::where([
            ['points',$user->watchedLessons],
            ['model_type','App\Models\Lesson']
        ])->first();
        if($achievement){
            $unlockAchievement = new UnlockAchievementsService();
            $unlockAchievement->unlockAchievement($user,$achievement);
        }
    }
}
