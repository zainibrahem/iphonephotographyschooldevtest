<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\User;
use App\Services\UnlockAchievementsService;
use Illuminate\Support\Facades\Log;
class CommentWrittenListener
{
    
    public $user;
    /**
     * Create the event listener.
     */
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWritten $event): void
    {
        $user = $event->user;
        $comments = $user->comments();
        
        $achievement = Achievement::where([
            ['points',$comments->count()],
            ['model_type','App\Models\Comment']
        ])->first();
        if($achievement){
            Log::info('ach : '. $achievement);
            $unlockAchievement = new UnlockAchievementsService();
            $unlockAchievement->unlockAchievement($user,$achievement);
        }
    }
}
