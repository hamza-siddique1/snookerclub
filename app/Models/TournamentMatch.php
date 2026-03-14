<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Plus;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $table = 'tournament_matches';

    protected $fillable = [
        'tournament_id',
        'year',
        'round',
        'match_number',
        'player1_id',
        'player2_id',
        'score_player_1',
        'score_player_2',
        'break_run_player_1',
        'break_run_player_2',
        'winner_id',
        'next_match_id',
        'next_match_slot',
        'status',
        'table'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function player1()
    {
        return $this->belongsTo(Player::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(Player::class, 'player2_id');
    }

    public function winner()
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }

    public function nextMatch()
    {
        return $this->belongsTo(TournamentMatch::class, 'next_match_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function hasPlayers()
    {
        return $this->player1_id && $this->player2_id;
    }

    public function isReady()
    {
        return $this->player1_id && $this->player2_id && !$this->winner_id;
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeRound($query, $round)
    {
        return $query->where('round', $round);
    }

    public function scopeTournament($query, $tournamentId)
    {
        return $query->where('tournament_id', $tournamentId);
    }

}
