<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'total_players',
        'status',
        'type',
        'year'
    ];


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

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Bracket Helpers
    |--------------------------------------------------------------------------
    */

    public function matchesByRound()
    {
        return $this->matches()
            ->orderBy('round')
            ->orderBy('match_number')
            ->get()
            ->groupBy('round');
    }

    public function firstRoundMatches()
    {
        return $this->matches()->where('round', 1);
    }

    public function finalMatch()
    {
        return $this->matches()
            ->orderByDesc('round')
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRunning()
    {
        return $this->status === 'running';
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }
}
