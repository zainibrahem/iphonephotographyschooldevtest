<?php
namespace Tests\Unit;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Services\LessonService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AchievementSystemTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    // here is a way of testing all the achievements in one test function, or we can do it the hard way and make sure the user have achieved every single one of them
    public function testUserCanUnlockFirstLessonWatchedAchievement()
    {
            $i = 1;
            $user = User::factory()->create();
            $lesson = Lesson::factory()->create();
            while($i <= 50){
                $lessonService = new LessonService();
                $lessonService->watchLesson($user,$lesson->id);
                if($i == 1){
                    $achievementName = 'First Lesson Watched';
                }
                else{
                    $achievementName = $i.' Lesson Watched';
                }
                $achievement = Achievement::where('name',$achievementName)->first();
                if($achievement){
                    $this->assertTrue($user->hasAchieved($achievement));
                }
                $i++;
            }   
            $this->refreshApplication();
        
    }


    public function testUserCanUnlockFirstCommentWrittenAchievement()
    {
        $i = 1;
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        while($i <= 20){
            $user->writeComment($user,'this is a test comment');
            if($i == 1){
                $achievementName = 'First Comment Written';
            }
            else{
                $achievementName = $i.' Comment Written';
            }
            $achievement = Achievement::where('name',$achievementName)->first();
            if($achievement){
                $this->assertTrue($user->hasAchieved($achievement));
            }
            $i++;
        }   
        $this->refreshApplication();
    }
    public function testUserCanUnlockIntermediateBadge()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        for($i = 0 ; $i < 6; $i++){
            $lessonService = new LessonService();
            $lessonService->watchLesson($user,$lesson->id);
            $user->writeComment($user,'this is a test comment');
        }

        $this->assertEquals('Intermediate', $user->getBadge());
    }

    public function testUserCanUnlockAdvancedBadge()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        for($i = 0 ; $i < 21; $i++){
            $lessonService = new LessonService();
            $lessonService->watchLesson($user,$lesson->id);
            $user->writeComment($user,'this is a test comment');
        }
        $this->assertEquals('Advanced', $user->getBadge());
    }

    public function testUserCanUnlockMasterBadge()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        for($i = 0 ; $i < 50; $i++){
            $lessonService = new LessonService();
            $lessonService->watchLesson($user,$lesson->id);
        }
        for($j = 0; $j < 21 ; $j++){
            $user->writeComment($user,'this is a test comment');
        }
        $this->assertEquals('Master', $user->getBadge());
    }
}