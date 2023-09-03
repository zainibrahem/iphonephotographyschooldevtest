<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestComments extends TestCase
{
    use RefreshDatabase;
    private $user;
    /**
     * A basic unit test example.
     */


    protected function setUp():void{
        parent::setUp();
        $this->user = User::find(1);
       
    }
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
      /**
     * Test the successful unlock of the first comment written achievement.
     */
    public function testSuccessfulUnlockOfFirstCommentWrittenAchievement()
    {
        
        $this->user->writeComment($this->user,'this is a comment');

        $achievement = Achievement::where('name','First Comment Written')->first();
        $this->assertTrue($this->user->hasAchieved($achievement->name));
    }

   
}
