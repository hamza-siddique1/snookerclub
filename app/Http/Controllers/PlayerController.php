<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PlayerController extends Controller
{

    public function index()
    {
        $players = Player::latest()->get();
        return view('pages.players.index', compact('players'));
    }


    public function create()
    {
        return view('pages.players.add');
    }

    public function show(Player $player)
    {
        // Get player's match statistics
        $allMatches = TournamentMatch::where(function ($query) use ($player) {
            $query->where('player1_id', $player->id)
                ->orWhere('player2_id', $player->id);
        })
        ->with(['tournament', 'player1', 'player2', 'winner'])
        ->get();

        // Calculate stats
        $totalMatches = $allMatches->count();
        $wins = $allMatches->where('winner_id', $player->id)->count();
        $losses = $totalMatches - $wins;
        $winPercentage = $totalMatches > 0 ? ($wins / $totalMatches) * 100 : 0;

        // Get highest break
        $highestBreak = $allMatches->map(function ($match) use ($player) {
            return $match->player1_id == $player->id ? $match->break_run_player_1 : $match->break_run_player_2;
        })->max();

        // Get recent matches
        $recentMatches = $allMatches->sortByDesc('created_at')->take(5);
        return view('pages.players.front.index', get_defined_vars());
    }


    public function store(Request $request)
    {
        $slug = Str::slug($request->name);
        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $image_1_name = $slug . '_1.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('players'), $image_1_name);
        } else {
            $image_1_name = null;
        }

        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $image_2_name = $slug . '_2.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('players'), $image_2_name);
        } else {
            $image_2_name = null;
        }

        if ($request->hasFile('ranking_image')) {

            $file = $request->file('ranking_image');

            $ranking_image_name = $slug . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('players', $ranking_image_name, 'public');

        } else {
            $path = null;
        }

        $year = substr($request->professional_since, 0, 4);

        Player::create([
            'name' => $request->name,
            'dob' => $request->dob,
            'birth_place' => $request->birth_place,
            'residence' => $request->residence,
            'plays_with' => $request->plays_with,
            'professional_since' => $year,
            'titles' => $request->titles,
            'earnings' => $request->earnings,
            'image1' => $image_1_name,
            'image2' => $image_2_name,
            'ranking_image' => $path,
            'cue' => $request->cue,
            'cue_link' => $request->cue_link,
        ]);

        Session::flash('success', 'Player successfully added.');
        return redirect()->route('admin.players.create');


    }

    public function destroy(Player $player)
    {
        $player->delete();
        Session::flash('success', 'Player deleted successfully.');
        return redirect()->route('admin.players.index');
    }
}
