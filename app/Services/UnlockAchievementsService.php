<?php

namespace App\Services;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use App\Services\UnlockBadgeService;
class UnlockAchievementsService
{
    public function unlockAchievement(User $user,Achievement $achievement){
            if (!$user->hasAchieved($achievement)) {
                // The user has not unlocked the achievement, so we unlock it now.
                $user->achievements()->attach($achievement);
                
                $unlockBadge = new UnlockBadgeService();
                $unlockBadge->unlockBadge($user);

                event(new AchievementUnlocked($achievement->name,$user));
            }
    }
}