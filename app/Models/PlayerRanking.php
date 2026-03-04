<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerRanking extends Model
{
    protected $table = 'player_rankings';

    protected $fillable = [
        'player_id',
        'score',
        'rank'
    ];

    protected $casts = [
        'score' => 'integer',
        'rank' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public static function getActiveRankings()
    {
        return self::where('is_active', true)
            ->with('player')
            ->orderByDesc('score')
            ->get()
            ->each(function ($ranking, $index) {
                $ranking->rank = $index + 1;
            });
    }

    public static function updateRankings()
    {
        $rankings = self::orderByDesc('score')
            ->get();

        foreach ($rankings as $index => $ranking) {
            $ranking->update(['rank' => $index + 1]);
        }

        return $rankings;
    }

    public static function getPlayerRank($playerId)
    {
        $ranking = self::where('player_id', $playerId)
            ->first();

        return $ranking?->rank ?? null;
    }

    public static function getTopRankings($limit = 10)
    {
        return self::with('player')
            ->orderByDesc('score')
            ->limit($limit)
            ->get();
    }

    public function increaseScore($points = 1)
    {
        $this->increment('score', $points);
        self::updateRankings();
    }

    public function decreaseScore($points = 1)
    {
        $this->decrement('score', $points);
        self::updateRankings();
    }

    public function toRankingData()
    {
        return [
            'id' => $this->id,
            'player_id' => $this->player_id,
            'player_name' => $this->player->name ?? 'Unknown',
            'score' => $this->score,
            'rank' => $this->rank,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
