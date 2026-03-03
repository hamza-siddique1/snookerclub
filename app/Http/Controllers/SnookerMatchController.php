<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SnookerMatch;
use App\Models\Tournament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SnookerMatchController extends Controller
{
    public function index()
    {
        $matches = SnookerMatch::latest()->get();
        return view('snooker.index', compact('matches'));
    }

    /**
     * Show match setup page
     */
    public function setup()
    {
        $players = Player::orderBy('name')->get();
        return view('snooker.setup', compact('players'));
    }

    public function setup_existing_match()
    {
        $matches = Tournament::with([
                'player1:id,name',
                'player2:id,name'
            ])
            ->select(['id', 'tournament', 'player_1', 'player_2'])
            ->where('type', 'snooker')
            ->latest()
            ->get();

        return view('snooker.add-existing-match', compact('matches'));
    }

    /**
     * Create a new match
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'player_1_id' => 'required|exists:players,id',
            'player_2_id' => 'required|exists:players,id|different:player_1_id',
            'table_number' => 'nullable|string|max:20',
        ]);

        $player1 = Player::find($validated['player_1_id']);
        $player2 = Player::find($validated['player_2_id']);

        $match = SnookerMatch::create([
            'player_1_id' => $player1->id,
            'player_2_id' => $player2->id,
            'player_1_name' => $player1->name,
            'player_2_name' => $player2->name,
            'table_number' => $validated['table_number'] ?? 'TABLE 1',
            'table_name' => 'Snooker Arena',
            'status' => 'playing',
            'started_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'match' => $match,
            'remote_url' => route('snooker.remote', $match->slug),
            'lcd_url' => route('snooker.lcd', $match->slug),
        ]);
    }

    public function create_existing(Request $request): JsonResponse
    {
        $match = Tournament::find($request->match);

        $match = SnookerMatch::create([
            'player_1_id' => $match->player_1,
            'player_2_id' => $match->player_2,
            'player_1_name' => get_player_name($match->player_1),
            'player_2_name' => get_player_name($match->player_2),
            'table_number' => $request->table_number ?? 'TABLE 1',
            'started_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'match' => $match,
            'remote_url' => route('snooker.remote', $match->slug),
            'lcd_url' => route('snooker.lcd', $match->slug),
        ]);
    }

    /**
     * Show LCD display
     */
    public function lcd(SnookerMatch $match)
    {
        return view('snooker.lcd', compact('match'));
    }

    /**
     * Show remote control
     */
    public function remote(SnookerMatch $match)
    {
        return view('snooker.remote', compact('match'));
    }

    /**
     * Get match data (for polling)
     */
    public function getMatchData(SnookerMatch $match): JsonResponse
    {
        return response()->json($match->toMatchData());
    }

    /**
     * Add points to a player
     */
    public function addPoints(Request $request, SnookerMatch $match): JsonResponse
    {
        $validated = $request->validate([
            'player' => 'required|in:player_1,player_2',
            'points' => 'required|integer|in:1,2,3,4,5,6,7',
        ]);

        try {
            $match->addPoints($validated['player'], $validated['points']);

            return response()->json([
                'success' => true,
                'message' => "Added {$validated['points']} points",
                'match' => $match->toMatchData(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Switch player (end turn)
     */
    public function switchPlayer(Request $request, SnookerMatch $match): JsonResponse
    {
        try {
            $match->switchPlayer();

            return response()->json([
                'success' => true,
                'message' => 'Player switched',
                'match' => $match->toMatchData(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Reset break (player misses)
     */
public function resetBreak(Request $request, SnookerMatch $match): JsonResponse
{
    $validated = $request->validate([
        'player' => 'required|in:player_1,player_2',
    ]);

    try {
        // Get the player who just played
        $currentPlayer = $validated['player'];

        // Reset their break to 0
        $match->resetBreak($currentPlayer);

        // Switch to the other player
        $match->switchPlayer();

        return response()->json([
            'success' => true,
            'message' => 'Break reset and player switched',
            'match' => $match->toMatchData(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}

    /**
     * End frame (declare winner)
     */
    public function endFrame(Request $request, SnookerMatch $match): JsonResponse
    {
        $validated = $request->validate([
            'winner' => 'required|in:player_1,player_2',
        ]);

        try {
            $match->endFrame($validated['winner']);

            return response()->json([
                'success' => true,
                'message' => 'Frame ended',
                'match' => $match->toMatchData(),
                'match_completed' => $match->status === 'completed',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Undo last action
     */
    public function undo(SnookerMatch $match): JsonResponse
    {
        try {
            $success = $match->undoLastAction();

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'No actions to undo',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Action undone',
                'match' => $match->toMatchData(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Reset entire match
     */
    public function resetMatch(SnookerMatch $match): JsonResponse
    {
        try {
            $match->resetMatch();

            return response()->json([
                'success' => true,
                'message' => 'Match reset',
                'match' => $match->toMatchData(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update match status (pause/resume)
     */
    public function updateStatus(Request $request, SnookerMatch $match): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:playing,paused,completed',
        ]);

        $match->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'match' => $match->toMatchData(),
        ]);
    }
}
