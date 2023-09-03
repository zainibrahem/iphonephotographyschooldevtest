<?php

namespace App\Services;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UnlockBadgeService
{
    public function unlockBadge(User $user){
        $badge = Badge::where('required_achievements',$user->achievements()->count())->first();
        if($badge){
            Log::info('badge :' .$badge);
            $user->badge_id = $badge->id;
            $user->save();
            event(new BadgeUnlocked($badge->name,$user));
        }

    }
}