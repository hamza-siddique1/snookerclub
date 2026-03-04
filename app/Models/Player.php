<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
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
        'ranking_image',
        'cue',
        'cue_link',
    ];
    protected $casts = [
        'dob' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

}
