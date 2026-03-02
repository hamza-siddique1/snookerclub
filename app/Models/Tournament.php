<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_1',
        'player_2',
        'year',
        'tournament',
        'rules',
        'round',
        'winner',
        'result',
        'type',
        'status',
        'draw_url',
        'score_player_1',
        'score_player_2',
        'break_run_player_1',
        'break_run_player_2',
        'level',
        'table'
    ];

    protected $casts = [
        'year' => 'datetime',
    ];

    public function frames()
    {
        return $this->hasMany(TournamentFrames::class);
    }

    public function player1()
    {
        return $this->hasOne(Player::class, 'id', 'player_1');
    }

    public function player2()
    {
        return $this->hasOne(Player::class, 'id', 'player_2');
    }

    public const KEY_ACTION_CREATED = 0;
    public const KEY_ACTION_STARTED = 1;
    public const KEY_ACTION_INTERRUPTED = 2;
    public const KEY_ACTION_BREAK = 3;
    public const KEY_ACTION_RESUMED = 4;
    public const KEY_ACTION_FINISHED = 5;

    public const ACTION_CREATED = 'Created';
    public const ACTION_STARTED = 'Started'; // live
    public const ACTION_INTERRUPTED = 'Interrupted'; // Interrupted
    public const ACTION_BREAK = 'Break'; // break
    public const ACTION_RESUMED = 'Resumed'; // live
    public const ACTION_FINISHED = 'Finished'; // finished

    public const ACTIONS = [
        self::KEY_ACTION_CREATED => self::ACTION_CREATED,
        self::KEY_ACTION_STARTED => self::ACTION_STARTED,
        self::KEY_ACTION_INTERRUPTED => self::ACTION_INTERRUPTED,
        self::KEY_ACTION_BREAK => self::ACTION_BREAK,
        self::KEY_ACTION_RESUMED => self::ACTION_RESUMED,
        self::KEY_ACTION_FINISHED => self::ACTION_FINISHED,
    ];




}
