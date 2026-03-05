<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SnookerMatch extends Model
{
    protected $fillable = [
        'match_uuid',
        'slug',
        'player_1_id',
        'player_2_id',
        'player_1_name',
        'player_2_name',
        'frames_to_win',
        'total_frames',
        'current_frame',
        'player_1_frames',
        'player_2_frames',
        'player_1_points',
        'player_2_points',
        'player_1_break',
        'player_2_break',
        'actions_history',
        'table_number',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'actions_history' => 'json',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->match_uuid = Str::uuid();
            $model->slug = Str::slug($model->player_1_name . '-vs-' . $model->player_2_name . '-' . now()->timestamp);
        });
    }

    /**
     * Get route key name
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationships
     */
    public function player1(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_1_id');
    }

    public function player2(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_2_id');
    }

    /**
     * Add points to a player
     */
    public function addPoints(string $player, int $points): void
    {
        $this->validatePoints($points);
        $this->recordAction('add_points', compact('player', 'points'));

        if ($player === 'player_1') {
            $this->player_1_points += $points;
            $this->player_1_break += $points;
        } else {
            $this->player_2_points += $points;
            $this->player_2_break += $points;
        }

        $this->save();
    }


    /**
     * End current frame (declare winner)
     */
    public function endFrame(string $winner): void
    {
        $this->validateFrameWinner($winner);
        $this->recordAction('end_frame', compact('winner'));

        if ($winner === 'player_1') {
            $this->player_1_frames++;
        } else {
            $this->player_2_frames++;
        }

        // Check if match is won
        if ($this->isMatchWon()) {
            $this->ended_at = now();
        } else {
            // Start new frame
            $this->current_frame++;
            $this->player_1_points = 0;
            $this->player_2_points = 0;
            $this->player_1_break = 0;
            $this->player_2_break = 0;
            $this->current_player = 'player_1'; // Always player 1 starts frame
        }

        $this->save();
    }

    /**
     * Undo last action
     */
    public function undoLastAction(): bool
    {
        $history = $this->actions_history ?? [];

        if (empty($history)) {
            return false;
        }

        $lastAction = array_pop($history);
        $this->actions_history = $history;

        // Revert based on action type
        $this->revertAction($lastAction);
        $this->save();

        return true;
    }

    /**
     * Revert an action
     */
    private function revertAction(array $action): void
    {
        match ($action['type']) {
            'add_points' => $this->revertAddPoints($action['data']),
            'switch_player' => $this->revertSwitchPlayer(),
            'reset_break' => $this->revertResetBreak($action['data']),
            default => null,
        };
    }

    /**
     * Revert add points
     */
    private function revertAddPoints(array $data): void
    {
        if ($data['player'] === 'player_1') {
            $this->player_1_points -= $data['points'];
            $this->player_1_break -= $data['points'];
        } else {
            $this->player_2_points -= $data['points'];
            $this->player_2_break -= $data['points'];
        }
    }

    /**
     * Revert switch player
     */
    private function revertSwitchPlayer(): void
    {
        $this->current_player = $this->current_player === 'player_1' ? 'player_2' : 'player_1';
    }

    /**
     * Revert reset break
     */
    private function revertResetBreak(array $data): void
    {
        // This is tricky - we'd need to store the previous break value
        // For now, we'll just reset to 0
        if ($data['player'] === 'player_1') {
            $this->player_1_break = 0;
        } else {
            $this->player_2_break = 0;
        }
    }

    /**
     * Record an action in history
     */
    private function recordAction(string $type, array $data = []): void
    {
        $history = $this->actions_history ?? [];

        $history[] = [
            'type' => $type,
            'data' => $data,
            'timestamp' => now()->toIso8601String(),
        ];

        $this->actions_history = $history;
    }

    /**
     * Validate points value (1-7 only)
     */
    private function validatePoints(int $points): void
    {
        if (!in_array($points, [1, 2, 3, 4, 5, 6, 7])) {
            throw new \InvalidArgumentException('Points must be between 1 and 7');
        }
    }

    /**
     * Validate frame winner
     */
    private function validateFrameWinner(string $winner): void
    {
        if (!in_array($winner, ['player_1', 'player_2'])) {
            throw new \InvalidArgumentException('Invalid player');
        }
    }

    /**
     * Check if match is won
     */
    private function isMatchWon(): bool
    {
        return $this->player_1_frames >= $this->frames_to_win
            || $this->player_2_frames >= $this->frames_to_win;
    }

    /**
     * Get match winner
     */
    public function getWinner(): ?string
    {
        if ($this->player_1_frames > $this->player_2_frames) {
            return 'player_1';
        } elseif ($this->player_2_frames > $this->player_1_frames) {
            return 'player_2';
        }
        return null;
    }

    /**
     * Get current player
     */
    public function getCurrentPlayerName(): string
    {
        return $this->current_player === 'player_1' ? $this->player_1_name : $this->player_2_name;
    }

    /**
     * Get lead information
     */
    public function getLeadInfo(): array
    {
        $diff = $this->player_1_frames - $this->player_2_frames;

        return [
            'leader' => $diff > 0 ? 'player_1' : ($diff < 0 ? 'player_2' : 'tied'),
            'lead_count' => abs($diff),
        ];
    }

    /**
     * Reset entire match
     */
    public function resetMatch(): void
    {
        $this->recordAction('reset_match');

        $this->current_frame = 1;
        $this->player_1_frames = 0;
        $this->player_2_frames = 0;
        $this->player_1_points = 0;
        $this->player_2_points = 0;
        $this->player_1_break = 0;
        $this->player_2_break = 0;
        $this->current_player = 'player_1';
        $this->status = 'playing';
        $this->started_at = now();

        $this->save();
    }

    /**
     * Export match data for API
     */
    public function toMatchData(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'match_uuid' => $this->match_uuid,
            'player_1' => [
                'name' => $this->player_1_name,
                'points' => $this->player_1_points,
                'break' => $this->player_1_break,
                'frames' => $this->player_1_frames,
            ],
            'player_2' => [
                'name' => $this->player_2_name,
                'points' => $this->player_2_points,
                'break' => $this->player_2_break,
                'frames' => $this->player_2_frames,
            ],
            'current_frame' => $this->current_frame,
            'current_player' => $this->current_player,
            'current_player_name' => $this->getCurrentPlayerName(),
            'frames_to_win' => $this->frames_to_win,
            'status' => $this->status,
            'table_name' => $this->table_name,
            'table_number' => $this->table_number,
            'lead' => $this->getLeadInfo(),
            'is_completed' => $this->status === 'completed',
            'winner' => $this->getWinner(),
        ];
    }

    public function resetBreak(string $player): void
{
    $this->recordAction('reset_break', compact('player'));

    if ($player === 'player_1') {
        $this->player_1_break = 0;  // ← Reset to 0
    } else {
        $this->player_2_break = 0;  // ← Reset to 0
    }

    $this->save();
}

/**
 * Switch player (end of turn)
 */
public function switchPlayer(): void
{
    $this->recordAction('switch_player');

    $this->current_player = $this->current_player === 'player_1' ? 'player_2' : 'player_1';
    $this->save();
}
}
