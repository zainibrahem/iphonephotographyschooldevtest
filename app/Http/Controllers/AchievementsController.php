<?php

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\User;
use App\Services\LessonService;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AchievementsController extends Controller
{
    public function index(Request $request, User $user)
    {
        $user = $request->user();
        if(is_null($user)){
            $user = User::findOrFail(1);
        }
        $nextAvailableAchievements = $user->getNextAvailableAchievements();
        $remainingToUnlockNextBadge = $user->getRemainingToUnlockNextBadge();
        $unlockedAchievements = $user->getUnlockedAchievements();
        $currentBadge = $user->getBadge();
        $nextBadge = $user->getNextBadge();

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ]);
    }
    public function watched(){
        $user = User::findOrFail(1);
        return $user->watched;
    }
    public function watchedLesson($id){
        $userID = 1;
        $user = User::findOrFail($userID);
        if($user){
           $lessonService = new LessonService();
           $lessonService->watchLesson($user,$id);
        }
        return response()->json([
            'user'=>$user,
            'achievements'=> $user->achievements(),
            'badges'=> $user->badge
        ]);
    }

    public function comment(Request $request){
        $request->validate([
            'body' => 'required',
        ]);

        $comment = Comment::create([
            'body' => $request->body,
            'user_id' => $request->user_id ?? 1
        ]);
        $createdComment = $comment->fresh();
        $userId = $request->user_id ?? 1;
        // we can get the user : Auth::user(); if there is an authenticated implemented but in this case I'm sending the user_id as a request parameter since the authenticate implementing is out of the test scope 
        $user = User::findOrFail($userId);

        event(new CommentWritten($createdComment,$user));
    }
    
}
