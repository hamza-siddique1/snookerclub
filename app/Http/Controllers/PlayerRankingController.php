<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerRanking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerRankingController extends Controller
{
    public function index(): View
    {
        $rankings = PlayerRanking::with('player')
            ->orderByDesc('score')
            ->get();

        $players = Player::orderBy('name')->get();

        return view('pages.rankings.index', compact('rankings', 'players'));
    }

    public function getRankings(): JsonResponse
    {
        $rankings = PlayerRanking::with('player')
            ->orderByDesc('score')
            ->get()
            ->map(function ($ranking, $index) {
                $data = $ranking->toRankingData();
                $data['rank'] = $index + 1;
                return $data;
            });

        return response()->json([
            'success' => true,
            'data' => $rankings,
        ]);
    }

    public function getPlayers(): JsonResponse
    {
        $players = Player::orderBy('name')
            ->get()
            ->map(function ($player) {
                return [
                    'id' => $player->id,
                    'name' => $player->name,
                ];
            });

        return response()->json([
            'success' => true,
            'players' => $players,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'score' => 'required|integer|min:0',
        ]);

        try {
            $ranking = PlayerRanking::create([
                'player_id' => $validated['player_id'],
                'score' => $validated['score']
            ]);

            PlayerRanking::updateRankings();

            $allRankings = PlayerRanking::with('player')
                ->orderByDesc('score')
                ->get()
                ->map(function ($r, $index) {
                    $data = $r->toRankingData();
                    $data['rank'] = $index + 1;
                    return $data;
                });

            return response()->json([
                'success' => true,
                'message' => 'Ranking added successfully',
                'ranking' => $ranking->toRankingData(),
                'rankings' => $allRankings,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(Request $request, PlayerRanking $ranking): JsonResponse
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        try {
            $ranking->update($validated);

            PlayerRanking::updateRankings();

            $allRankings = PlayerRanking::with('player')
                ->orderByDesc('score')
                ->get()
                ->map(function ($r, $index) {
                    $data = $r->toRankingData();
                    $data['rank'] = $index + 1;
                    return $data;
                });

            return response()->json([
                'success' => true,
                'message' => 'Ranking updated successfully',
                'ranking' => $ranking->toRankingData(),
                'rankings' => $allRankings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function destroy(PlayerRanking $ranking): JsonResponse
    {
        try {
            $ranking->delete();

            $allRankings = PlayerRanking::with('player')
                ->orderByDesc('score')
                ->get()
                ->map(function ($r, $index) {
                    $data = $r->toRankingData();
                    $data['rank'] = $index + 1;
                    return $data;
                });

            return response()->json([
                'success' => true,
                'message' => 'Ranking deleted successfully',
                'rankings' => $allRankings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function increaseScore(Request $request, PlayerRanking $ranking): JsonResponse
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        try {
            $ranking->increaseScore($validated['points']);

            $allRankings = PlayerRanking::where('is_active', true)
                ->with('player')
                ->orderByDesc('score')
                ->get()
                ->map(function ($r, $index) {
                    $data = $r->toRankingData();
                    $data['rank'] = $index + 1;
                    return $data;
                });

            return response()->json([
                'success' => true,
                'message' => 'Score increased successfully',
                'rankings' => $allRankings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function decreaseScore(Request $request, PlayerRanking $ranking): JsonResponse
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        try {
            $ranking->decreaseScore($validated['points']);

            $allRankings = PlayerRanking::where('is_active', true)
                ->with('player')
                ->orderByDesc('score')
                ->get()
                ->map(function ($r, $index) {
                    $data = $r->toRankingData();
                    $data['rank'] = $index + 1;
                    return $data;
                });

            return response()->json([
                'success' => true,
                'message' => 'Score decreased successfully',
                'rankings' => $allRankings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function leaderboard()
    {
        $rankings = PlayerRanking::getTopRankings(100);

        return view('pages.rankings.leaderboard', compact('rankings'));
    }
}
