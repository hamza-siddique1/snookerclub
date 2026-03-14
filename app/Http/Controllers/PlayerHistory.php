<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentMatch;

class PlayerHistory extends Controller
{
    public function index()
    {
        $data = request()->all();

        $graph_data = ['labels' => [], 'data' => [1, 1]];

        if (!(isset($data['player1']) && $data['player1'] != -100 && isset($data['player2']) && $data['player2'] != -100)) { // if player1 is set, then we are looking for a match

            $player1 = null;
            $player2 = null;
        } else {

            $player1 = Player::find($data['player1']);
            $player2 = Player::find($data['player2']);

            $player1_wins = 0;
            $player2_wins = 0;
            $graph_data['labels'] = [sprintf("%s (%d wins)", $player2->name, $player2_wins), sprintf("%s (%d wins)", $player1->name, $player1_wins)];

            $matches = Tournament::WhereIn('player_1', [$player1->id, $player2->id])
                ->WhereIn('player_2', [$player1->id, $player2->id])
                ->Where('type', $data['type'])
                ->get();


            if (count($matches) > 0) {
                $player1_wins = $matches->where('winner', $data['player1'])->count();
                $player2_wins = $matches->where('winner', $data['player2'])->count();
//dd($player1_wins, $player2_wins);
                try {
                    $player1_win_percentage = ($player1_wins / ($player1_wins + $player2_wins)) * 100;
                    $player2_win_percentage = ($player2_wins / ($player1_wins + $player2_wins)) * 100;
                } catch (\Exception $e) {
                    $player1_win_percentage = 0;
                    $player2_win_percentage = 0;
                }


                $graph_data = [
                    'labels' => [sprintf("%s (%d wins)", $player2->name, $player2_wins), sprintf("%s (%d wins)", $player1->name, $player1_wins)],
                    'data' => [$player2_wins, $player1_wins]
                ];
            }
        }


        $players = Player::all();


//        dd($graph_data['labels'], $player1_win_percentage, $player2_win_percentage);

        return view('pages.playerhistory.index', get_defined_vars(), $graph_data);
    }

    public function index_front()
    {
        $data = request()->all();
        $graph_data = ['labels' => [], 'data' => [1, 1]];
        $matches = [];
        $player1_win_percentage = 0;
        $player2_win_percentage = 0;

        if(!isset($data['type'])) {
            $data['type'] = '8-pool';
        }
        if (!isset($data['player1']) || !isset($data['player2'])) {
            $player1 = Player::where('highlighted', 1)->first();
            $player2 = Player::where('highlighted', 1)->skip(1)->take(1)->first();

        } else {
            $player1 = Player::where('name', 'like', '%' . $data['player1'] . '%')->first();
            $player2 = Player::where('name', 'like', '%' . $data['player2'] . '%')->first();

            if (!$player1 || !$player2) {
                return redirect()->route('homepage.front');
            }
        }

        $player1_wins = 0;
        $player2_wins = 0;
        $graph_data['labels'] = [sprintf("%s (%d wins)", $player2->name, $player2_wins), sprintf("%s (%d wins)", $player1->name, $player1_wins)];

        $matches = TournamentMatch::whereHas('tournament', function ($query) use ($data) {
            $query->where('type', $data['type']);
        })
        ->where(function ($query) use ($player1, $player2) {
            $query->where([
                ['player1_id', $player1->id],
                ['player2_id', $player2->id]
            ])->orWhere([
                ['player1_id', $player2->id],
                ['player2_id', $player1->id]
            ]);
        })
        ->with(['tournament', 'player1', 'player2', 'winner'])  // Add this line
        ->orderBy('created_at', 'desc')
        ->get();

        /**
         * Get player's overall wins/lost ratio dynamically
         */
        $player1_all_matches = $this->getPlayerMatches($data['type'], $player1);
        $player1_all_wins = $player1_all_matches->where('winner_id', $player1->id)->count();
        $player1_win_loss_ratio = sprintf('%d / %d', $player1_all_wins, $player1_all_matches->count() - $player1_all_wins);
        $player1_break_and_run = $player1_all_matches->sum(function ($match) use ($player1) {
            return $match->player1_id == $player1->id ? $match->break_run_player_1 : $match->break_run_player_2;
        });

        $player2_all_matches = $this->getPlayerMatches($data['type'], $player2);
        $player2_all_wins = $player2_all_matches->where('winner_id', $player2->id)->count();
        $player2_win_loss_ratio = sprintf('%d / %d', $player2_all_wins, $player2_all_matches->count() - $player2_all_wins);
        $player2_break_and_run = $player2_all_matches->sum(function ($match) use ($player2) {
            return $match->player1_id == $player2->id ? $match->break_run_player_1 : $match->break_run_player_2;
        });

        /**
         * wins/lost ratio dynamically end
         */

        if (count($matches) > 0) {
            $player1_wins = $matches->where('winner_id', $player1->id)->count();
            $player2_wins = $matches->where('winner_id', $player2->id)->count();

            try {
                $player1_win_percentage = ($player1_wins / ($player1_wins + $player2_wins)) * 100;
                $player2_win_percentage = ($player2_wins / ($player1_wins + $player2_wins)) * 100;
            } catch (\Exception $e) {
                $player1_win_percentage = 0;
                $player2_win_percentage = 0;
            }

            $graph_data = [
                'labels' => [sprintf("%s (%d wins)", $player2->name, $player2_wins), sprintf("%s (%d wins)", $player1->name, $player1_wins)],
                'data' => [$player2_wins, $player1_wins]
            ];
        }

        $players = Player::select('name')->get();

        return view('pages.playerhistory-front.index', get_defined_vars(), $graph_data);
    }

    function getPlayerMatches($type, $player){
        return TournamentMatch::whereHas('tournament', function ($query) use ($type) {
            $query->where('type', $type);
        })
        ->where(function ($query) use ($player) {
            $query->where('player1_id', $player->id)
                ->orWhere('player2_id', $player->id);
        })
        ->get();
    }

}
