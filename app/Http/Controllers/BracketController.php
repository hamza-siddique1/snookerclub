<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Http\Request;

class BracketController extends Controller
{
    /**
     * Display tournament bracket with exact HTML structure
     */
    public function show($tournamentId)
    {
        // Get all matches grouped by round
        $quarterFinals = Tournament::where('tournament', $tournamentId)
            ->where('round', 1)
            ->orderBy('id')
            ->get();

        $semiFinals = Tournament::where('tournament', $tournamentId)
            ->where('round', 2)
            ->orderBy('id')
            ->get();

        $final = Tournament::where('tournament', $tournamentId)
            ->where('round', 3)
            ->first();

        // Get tournament info
        $tournament = $quarterFinals->first();

        // Get player details
        $players = $this->enrichMatchesWithPlayerData($quarterFinals, $semiFinals, $final);

        return view('bracket.draw', [
            'tournament' => $tournament,
            'quarterFinals' => $quarterFinals,
            'semiFinals' => $semiFinals,
            'final' => $final,
            'tournamentId' => $tournamentId,
        ]);
    }

    /**
     * Enrich match data with player details
     */
    private function enrichMatchesWithPlayerData($qf, $sf, $final)
    {
        // Add player names and details to each match
        foreach ($qf as $match) {
            $match->player_1_obj = Player::find($match->player_1);
            $match->player_2_obj = Player::find($match->player_2);
        }

        foreach ($sf as $match) {
            $match->player_1_obj = Player::find($match->player_1);
            $match->player_2_obj = Player::find($match->player_2);
        }

        if ($final) {
            $final->player_1_obj = Player::find($final->player_1);
            $final->player_2_obj = Player::find($final->player_2);
        }

        return true;
    }

    /**
     * Update match result and auto-advance winner
     */
    public function updateMatch(Request $request, $matchId)
    {
        $validated = $request->validate([
            'winner_id' => 'required|integer|exists:players,id',
            'player_1_score' => 'required|integer|min:0',
            'player_2_score' => 'required|integer|min:0',
        ]);

        try {
            $match = Tournament::findOrFail($matchId);

            // Validate winner is one of the players
            if (!in_array($validated['winner_id'], [$match->player_1, $match->player_2])) {
                throw new \Exception('Invalid winner selected');
            }

            // Update match
            $match->update([
                'winner' => $validated['winner_id'],
                'score_player_1' => $validated['player_1_score'],
                'score_player_2' => $validated['player_2_score'],
                'result' => $validated['winner_id'] === $match->player_1 ? 'player_1_won' : 'player_2_won',
            ]);

            // Auto-create next round match
            $this->advanceWinner($match, $validated['winner_id']);

            return response()->json([
                'success' => true,
                'message' => 'Match updated successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Advance winner to next round
     */
    private function advanceWinner($match, $winnerId)
    {
        $currentRound = $match->round;

        // Don't advance if this is the final
        if ($currentRound >= 3) {
            return;
        }

        // Get all matches in current round
        $roundMatches = Tournament::where('tournament', $match->tournament)
            ->where('round', $currentRound)
            ->orderBy('id')
            ->get();

        // Find position of current match
        $matchPosition = $roundMatches->search(function ($m) use ($match) {
            return $m->id === $match->id;
        });

        // Calculate next round match position
        if ($currentRound === 1) {
            // Quarter-Finals to Semi-Finals
            // Matches 0,1 go to SF match 0
            // Matches 2,3 go to SF match 1
            $nextRoundPosition = floor($matchPosition / 2);
            $nextRound = 2;

            $this->createOrUpdateNextRoundMatch(
                $match->tournament,
                $nextRound,
                $nextRoundPosition,
                $winnerId
            );
        } elseif ($currentRound === 2) {
            // Semi-Finals to Final
            $nextRound = 3;

            $this->createOrUpdateNextRoundMatch(
                $match->tournament,
                $nextRound,
                0,
                $winnerId
            );
        }
    }

    /**
     * Create or update next round match
     */
    private function createOrUpdateNextRoundMatch($tournamentId, $nextRound, $position, $winnerId)
    {
        // Find or create match in next round at this position
        $nextMatches = Tournament::where('tournament', $tournamentId)
            ->where('round', $nextRound)
            ->orderBy('id')
            ->get();

        if (isset($nextMatches[$position])) {
            // Match exists, update it
            $nextMatch = $nextMatches[$position];

            if (is_null($nextMatch->player_1)) {
                $nextMatch->update(['player_1' => $winnerId]);
            } elseif (is_null($nextMatch->player_2)) {
                $nextMatch->update(['player_2' => $winnerId]);
            }
        } else {
            // Create new match
            Tournament::create([
                'tournament' => $tournamentId,
                'player_1' => $winnerId,
                'player_2' => null,
                'round' => $nextRound,
                'type' => 'single-elimination',
                'year' => now(),
            ]);
        }
    }

    /**
     * Get match data for modal edit
     */
    public function getMatch($matchId)
    {
        $match = Tournament::findOrFail($matchId);
        $player1 = Player::find($match->player_1);
        $player2 = Player::find($match->player_2);

        return response()->json([
            'success' => true,
            'match' => [
                'id' => $match->id,
                'player_1' => $match->player_1,
                'player_1_name' => $player1?->name ?? 'Unknown',
                'player_1_rank' => $player1?->rank,
                'player_2' => $match->player_2,
                'player_2_name' => $player2?->name ?? 'Unknown',
                'player_2_rank' => $player2?->rank,
                'score_player_1' => $match->score_player_1,
                'score_player_2' => $match->score_player_2,
                'winner' => $match->winner,
                'round' => $match->round,
            ]
        ]);
    }

    /**
     * Initialize new 8-player tournament
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'tournament_name' => 'required|string|max:255',
            'tournament_location' => 'required|string|max:255',
            'surface' => 'required|string|max:255',
            'players' => 'required|array|size:8',
            'players.*' => 'required|integer|exists:players,id',
        ]);

        try {
            $players = $validated['players'];

            // Create Quarter-Final matches
            $qfMatches = [
                ['player_1' => $players[0], 'player_2' => $players[1]],
                ['player_1' => $players[2], 'player_2' => $players[3]],
                ['player_1' => $players[4], 'player_2' => $players[5]],
                ['player_1' => $players[6], 'player_2' => $players[7]],
            ];

            $tournamentName = $validated['tournament_name'];

            foreach ($qfMatches as $match) {
                Tournament::create([
                    'tournament' => $tournamentName,
                    'player_1' => $match['player_1'],
                    'player_2' => $match['player_2'],
                    'round' => 1,
                    'type' => 'single-elimination',
                    'year' => now(),
                ]);
            }

            return redirect()->route('bracket.show', $tournamentName)
                ->with('success', 'Tournament created successfully');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get live bracket data (for AJAX updates)
     */
    public function getBracketData($tournamentId)
    {
        $quarterFinals = Tournament::where('tournament', $tournamentId)
            ->where('round', 1)
            ->orderBy('id')
            ->with('player1Details', 'player2Details')
            ->get();

        $semiFinals = Tournament::where('tournament', $tournamentId)
            ->where('round', 2)
            ->orderBy('id')
            ->with('player1Details', 'player2Details')
            ->get();

        $final = Tournament::where('tournament', $tournamentId)
            ->where('round', 3)
            ->with('player1Details', 'player2Details')
            ->first();

        return response()->json([
            'success' => true,
            'quarterFinals' => $this->formatMatches($quarterFinals),
            'semiFinals' => $this->formatMatches($semiFinals),
            'final' => $final ? $this->formatMatches(collect([$final]))[0] : null,
        ]);
    }

    /**
     * Format matches for JSON response
     */
    private function formatMatches($matches)
    {
        return $matches->map(function ($match) {
            return [
                'id' => $match->id,
                'player_1_id' => $match->player_1,
                'player_1_name' => $match->player1Details?->name ?? 'TBD',
                'player_1_rank' => $match->player1Details?->rank,
                'player_1_score' => $match->score_player_1,
                'player_2_id' => $match->player_2,
                'player_2_name' => $match->player2Details?->name ?? 'TBD',
                'player_2_rank' => $match->player2Details?->rank,
                'player_2_score' => $match->score_player_2,
                'winner_id' => $match->winner,
                'is_completed' => !is_null($match->winner),
                'round' => $match->round,
            ];
        })->toArray();
    }
}
