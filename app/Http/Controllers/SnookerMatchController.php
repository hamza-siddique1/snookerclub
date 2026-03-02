<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SnookerMatch;
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

    /**
     * Show LCD display
     */
    public function lcd(SnookerMatch $match)
    {
        // dd($match);
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
            $match->resetBreak($validated['player']);
            $match->switchPlayer();

            return response()->json([
                'success' => true,
                'message' => 'Break reset',
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

    /**
     * Get format configuration
     */
    private function getFormatConfig(string $format): array
    {
        return match ($format) {
            'best-of-9' => ['frames_to_win' => 5, 'total_frames' => 9],
            'best-of-19' => ['frames_to_win' => 10, 'total_frames' => 19],
            'best-of-35' => ['frames_to_win' => 18, 'total_frames' => 35],
        };
    }
}
