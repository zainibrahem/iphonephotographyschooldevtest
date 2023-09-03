<?php

namespace App\Models;

use App\Events\LessonWatched;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    public function watched()
    {
        if (! $this->user || ! $this->isBeingWatched()) {
            return;
        }

        event(new LessonWatched($this , $this->user));
    }

    public function isBeingWatched()
    {
        return $this->relation('views')->exists();
    }
}
