<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'birth_place',
        'residence',
        'plays_with',
        'professional_since',
        'win',
        'lost',
        'titles',
        'earnings',
        'image1',
        'image2',
        'cue',
        'cue_link',
    ];
    protected $casts = [
        'dob' => 'date',
    ];

}
