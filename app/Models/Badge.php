<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'required_achievements', //  A comma-separated list of the names of the achievements that are required to unlock the badge.
    ];
}
