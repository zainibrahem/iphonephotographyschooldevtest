<?php

namespace App\Services;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\User;
use App\Services\UnlockBadgeService;
use Illuminate\Support\Facades\DB;
class LessonService
{
    public function watchLesson(User $user,$id){
        $lesson = Lesson::findOrFail($id);
        $watchedLesson = $user->watchedLessons;
        $user->watchedLessons = $watchedLesson + 1;
        $user->save();
        $lessonUser = LessonUser::where([
                ['user_id',$user->id],
                ['lesson_id',$lesson->id]
            ])->first();
        
        if($lessonUser){
            $lessonUser = DB::table('lesson_user')->where([
                ['user_id',$user->id],
                ['lesson_id',$id]
            ])->update(['watched'=>DB::raw('watched + 1')]);
        }
        else{
            $user->watched()->attach($lesson);
            $lessonUser = DB::table('lesson_user')->where([
                ['user_id',$user->id],
                ['lesson_id',$id]
            ])->update(['watched'=>1]);
        }
        event(new LessonWatched($lesson,$user));
    }
}