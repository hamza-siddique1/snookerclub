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
        'title',
        'total_players',
          'type',
        'rules',
        'round',
        'winner',
        'result',

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


    /**
     * Define rounds for an 8-player tournament
     * Round 1: Quarter-Finals (4 matches)
     * Round 2: Semi-Finals (2 matches)
     * Round 3: Final (1 match)
     */
    const ROUNDS = [
        1 => 'Quarter-Finals',
        2 => 'Semi-Finals',
        3 => 'Final',
    ];

    const ROUND_NAMES = [
        'quarter-finals' => 1,
        'semi-finals' => 2,
        'final' => 3,
    ];

    /**
     * Get matches by round
     */
    public function scopeByRound($query, $round)
    {
        return $query->where('round', $round);
    }

    /**
     * Get bracket structure with players and results
     */
    public static function getBracketStructure($tournamentId)
    {
        $bracket = [
            'quarter-finals' => [],
            'semi-finals' => [],
            'final' => [],
        ];

        // Get Quarter-Finals matches
        $qf = Tournament::where('tournament', $tournamentId)
            ->where('round', 1)
            ->orderBy('id')
            ->get();

        foreach ($qf as $match) {
            $bracket['quarter-finals'][] = self::formatMatch($match);
        }

        // Get Semi-Finals matches
        $sf = Tournament::where('tournament', $tournamentId)
            ->where('round', 2)
            ->orderBy('id')
            ->get();

        foreach ($sf as $match) {
            $bracket['semi-finals'][] = self::formatMatch($match);
        }

        // Get Final match
        $final = Tournament::where('tournament', $tournamentId)
            ->where('round', 3)
            ->first();

        if ($final) {
            $bracket['final'][] = self::formatMatch($final);
        }

        return $bracket;
    }

    /**
     * Format match data for frontend
     */
    private static function formatMatch($match)
    {
        return [
            'id' => $match->id,
            'player_1' => [
                'id' => $match->player_1,
                'score' => $match->score_player_1,
                'is_winner' => $match->winner === $match->player_1,
            ],
            'player_2' => [
                'id' => $match->player_2,
                'score' => $match->score_player_2,
                'is_winner' => $match->winner === $match->player_2,
            ],
            'completed' => !is_null($match->winner),
            'winner_id' => $match->winner,
        ];
    }

    /**
     * Initialize tournament with 8 players
     */
    public static function initializeTournament($tournamentName, array $playerIds)
    {
        if (count($playerIds) !== 8) {
            throw new \Exception('Tournament must have exactly 8 players');
        }

        // Shuffle or keep in order (depending on your requirement)
        // For seeding, you might want to keep order
        $players = array_values($playerIds);

        // Create Quarter-Finals matches (4 matches)
        $quarterFinalMatches = [
            ['player_1' => $players[0], 'player_2' => $players[1]],
            ['player_1' => $players[2], 'player_2' => $players[3]],
            ['player_1' => $players[4], 'player_2' => $players[5]],
            ['player_1' => $players[6], 'player_2' => $players[7]],
        ];

        foreach ($quarterFinalMatches as $match) {
            Tournament::create([
                'tournament' => $tournamentName,
                'player_1' => $match['player_1'],
                'player_2' => $match['player_2'],
                'round' => 1,
                'type' => 'single-elimination',
                'year' => now(),
            ]);
        }

        return true;
    }

    /**
     * Update match result and create next round match if needed
     */
    public function updateMatchResult($winnerId, $player1Score, $player2Score)
    {
        // Validate winner
        if ($winnerId !== $this->player_1 && $winnerId !== $this->player_2) {
            throw new \Exception('Invalid winner');
        }

        // Update this match
        $this->update([
            'winner' => $winnerId,
            'score_player_1' => $player1Score,
            'score_player_2' => $player2Score,
            'result' => $winnerId === $this->player_1 ? 'player_1_won' : 'player_2_won',
        ]);

        // Create next round match if current round is not final
        if ($this->round < 3) {
            $this->createNextRoundMatch($winnerId);
        }

        return $this;
    }

    /**
     * Create next round match for winner
     */
    private function createNextRoundMatch($winnerId)
    {
        $nextRound = $this->round + 1;

        // Get all matches in current round
        $matchesInRound = Tournament::where('tournament', $this->tournament)
            ->where('round', $this->round)
            ->get();

        // Check if this is odd or even match in the round
        $matchIndex = $matchesInRound->search(function ($match) {
            return $match->id === $this->id;
        });

        // For Quarter-Finals (Round 1)
        if ($this->round === 1) {
            // Matches 0,1 winners play in semi-final 0
            // Matches 2,3 winners play in semi-final 1
            $semiIndex = floor($matchIndex / 2);

            $existingSemi = Tournament::where('tournament', $this->tournament)
                ->where('round', 2)
                ->where('id', '>=',
                    Tournament::where('tournament', $this->tournament)
                        ->where('round', 2)
                        ->min('id') + $semiIndex
                )
                ->first();

            if (!$existingSemi) {
                Tournament::create([
                    'tournament' => $this->tournament,
                    'player_1' => $winnerId,
                    'round' => 2,
                    'type' => 'single-elimination',
                    'year' => $this->year,
                ]);
            } else if (is_null($existingSemi->player_1)) {
                $existingSemi->update(['player_1' => $winnerId]);
            } else if (is_null($existingSemi->player_2)) {
                $existingSemi->update(['player_2' => $winnerId]);
            }
        }

        // For Semi-Finals (Round 2)
        if ($this->round === 2) {
            $existingFinal = Tournament::where('tournament', $this->tournament)
                ->where('round', 3)
                ->first();

            if (!$existingFinal) {
                Tournament::create([
                    'tournament' => $this->tournament,
                    'player_1' => $winnerId,
                    'round' => 3,
                    'type' => 'single-elimination',
                    'year' => $this->year,
                ]);
            } else if (is_null($existingFinal->player_1)) {
                $existingFinal->update(['player_1' => $winnerId]);
            } else if (is_null($existingFinal->player_2)) {
                $existingFinal->update(['player_2' => $winnerId]);
            }
        }
    }

}
