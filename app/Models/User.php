<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\CommentWritten;
use App\Services\LessonService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'watchedLessons',
        'badge_id',
        'password',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    public function writeComment(User $user, string $comment)
    {
        $comment = Comment::create([
            'body' => 'this is a testing comment',
            'user_id' => $user->id
        ]);
        $createdComment = $comment->fresh();
        event(new CommentWritten($createdComment,$user));
    }
    public function watchLessons(){
        $lessonService = new LessonService();
        $lessonService->watchLesson($this,1);
        return response()->json([
            'user'=>$this,
            'achievements'=> $this->achievements(),
            'badges'=> $this->badge
        ]);
    }
    
    public function watchLesson()
    {
        $this->watched()->attach(1);
    }

    public function watched(){
        return $this->belongsToMany(Lesson::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
    public function hasAchieved(Achievement $achievement)
    {
        return $this->achievements()->where('id', $achievement->id)->exists();
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function getUnlockedAchievements(){
        return $this->achievements;
    }
    public function getNextAvailableAchievements()
    {
        $lastLessonAchievement = $this->achievements()->where('model_type','App\Models\Lesson')->latest()->first();
        $lastCommentAchievement = $this->achievements()->where('model_type','App\Models\Comment')->latest()->first();
        
        return [
            $lastLessonAchievement,
            $lastCommentAchievement
        ];

    }
    public function getBadge()
    {
        return $this->badge->name;
    }
    public function getNextBadge()
    {
        $badge = $this->badge;
        $newBadgeId = $badge->id + 1;
        $nextBadge = Badge::findOrFail($newBadgeId);
        if($nextBadge){
            return $nextBadge->name;
        }
        else{
            return 'You have the last Badge! Well Done.';
        }
    }
    public function getRemainingToUnlockNextBadge()
    {
        $badge = $this->badge;
        $newBadgeId = $badge->id + 1;
        $nextBadge = Badge::findOrFail($newBadgeId);
        if($nextBadge){
            return $nextBadge->required_achievements - $this->achievements()->count() ;
        }
        else{
            return 'this is the last Badge! Well Done.';
        }
    }
}
