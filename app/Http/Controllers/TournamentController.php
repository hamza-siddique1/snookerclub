<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Services\TournamentBracketService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class TournamentController extends Controller
{

    public function index()
    {
        $tournaments = Tournament::with([
            'matches.player1',
            'matches.player2',
            'matches.winner'
        ])
        ->latest()
        ->get();

        return view('pages.matches.index', compact('tournaments'));
    }

    public function create()
    {
        $players = Player::latest()->get();
        return view('pages.matches.add', compact('players'));
    }


    public function store(Request $request)
    {
        // create match
        Tournament::create([
            'player_1' => $request->player_1,
            'player_2' => $request->player_2,
            'year' => $request->year,
            'tournament' => $request->tournament,
            'rules' => $request->rules,
            'round' => $request->round,
            'type' => $request->type,
            'status' => Tournament::KEY_ACTION_CREATED,
            'draw_url' => $request->draw_url,
            'score_player_1' => 0,
            'score_player_2' => 0,
            'table' => $request->table,
        ]);

        Session::flash('success', 'Tournament successfully added.');
        return redirect()->route('matches.create');
    }

    public function edit(TournamentMatch $match)
    {
        $match->load([
            'player1',
            'player2',
            'winner'
        ]);

        return view('pages.matches.edit', compact('match'));
    }

    public function update(Request $request, TournamentMatch $match)
    {
      $service = new TournamentBracketService();

      $service->updateMatch($match, $request->all());

    return redirect()
        ->back()
        ->with('success','Match updated successfully');

        $match->update([
            'round' => $request->round,

        ]);

        Session::flash('success', 'Successfully updated.');
        return back();
    }

    public function destroy(Tournament $match)
    {
        $match->frames()->delete();
        $match->delete();
        Session::flash('success', 'Tournament deleted successfully.');
        return redirect()->route('matches.index');
    }

    public function results2()
    {
        $matches = Tournament::latest()
            ->whereDate('year', Carbon::today())
            ->get();

        return view('pages.matches.results', compact('matches'));
    }

    public function results()
    {
        return view('pages.results.index');
    }

    public function results_api()
    {
        $data = request()->all();

        if (!isset($data['type'])) {
            $data['type'] = '8-pool';
        }

        $matches = Tournament::oldest('year')->where('type', $data['type'])->where('player_2', '!=', 0);
        if (isset($data['date'])) {
            $matches = $matches->whereMonth('year', $data['month'])->whereDay('year', $data['date']);
        } else {
            $matches = $matches->whereDate('year', Carbon::today());
        }

        $matches = $matches->get();

        $matches = $matches->groupBy('tournament')->all();

        foreach ($matches as $key => $match) {
            $matchNumber = 1;
            $match = $match->map(function ($item, $key) use (&$matchNumber) {
                return [
                    'id' => $item->id,
                    'match_number' => $matchNumber++,
                    'table_number' => $item->table,
                    'player_1' => get_player_name($item->player_1),
                    'player_1_slug' => get_player_slug($item->player_1),
                    'player_1_id' => $item->player_1,
                    'player_2' => get_player_name($item->player_2),
                    'player_2_slug' => get_player_slug($item->player_2),
                    'player_2_id' => $item->player_2,
                    'round' => $item->round,
                    'year' => $item->year->format('H:i'),
                    'score_player_1' => $item->status == 0 ? '-' : $item->score_player_1,
                    'score_player_2' => $item->status == 0 ? '-' : $item->score_player_2,
                    'winner' => $item->winner,
                    'draw_url' => $item->draw_url ?? $item->tournament,
                ];
            });

            $matches[$key] = $match->groupBy('round')->all();
        }

        return response()->json($matches);
    }

    public function results_details(Tournament $match)
    {
        $player_1 = $match->player_1;
        $player_2 = $match->player_2;

        $players = [$match->player_1, $match->player_2];

        $matches = Tournament::WhereIn('player_1', $players)
            ->WhereIn('player_2', $players)
            ->Where('type', $match->type)
            ->get();

        $player1_all_matches = Tournament::Where('type', $match->type)->latest('year');

        if ($match->status != Tournament::KEY_ACTION_FINISHED) {
            $player1_all_matches->where('id', '!=', $match->id);
        }

        $player1_all_matches = $player1_all_matches->where(function ($q) use ($player_1) {
            $q->where('player_1', $player_1)
                ->orWhere('player_2', $player_1);
        })->get();

        $player2_all_matches = Tournament::Where('type', $match->type)->latest('year');

        if ($match->status != Tournament::KEY_ACTION_FINISHED) {
            $player2_all_matches->where('id', '!=', $match->id);
        }
        $player2_all_matches = $player2_all_matches->where(function ($q) use ($player_2) {
            $q->where('player_1', $player_2)
                ->orWhere('player_2', $player_2);
        })->get();

        // update time
        $previous_total_time = (int)$match->total_time;

        $startTime = $match->start_time;
        $endTime = time();

        $totalDuration = $endTime - $startTime;
        if ($startTime == 0) {
            $totalDuration = 0;
        }
        $match->total_time = $previous_total_time + $totalDuration;

        return view('pages.results.match_detail', get_defined_vars());
    }

    public function results_details_frames_api(Tournament $match)
    {
        $frames = $match->load('frames');
        $frames = $frames->frames;

        $status = '';
        if (in_array($match->status, [1, 4])) {
            $status = 'LIVE';
        } elseif ($match->status == 2) {
            $status = 'Interrupted';
        } elseif ($match->status == 3) {
            $status = 'Break';
        } elseif ($match->status == 5) {
            $status = 'Finished';
        }

        return response()->json([
            'frames' => $frames,
            'score' => $match->score_player_1 . ' - ' . $match->score_player_2,
            'status' => $status
        ]);
    }


    public function contact()
    {
        return view('pages.contact.index');
    }

    public function about()
    {
        return view('pages.about.index');
    }

    public function send_email(Request $request)
    {
        Mail::to('imranengu@gmail.com')
            ->bcc('6793siddique@gmail.com')
            ->send(new \App\Mail\NewContact($request->all()));

        $submit = true;
        return view('pages.contact.index', compact('submit'));
    }

    public function stats()
    {
        $type = request()->type;
        $filter = request()->filter;

        if (is_null($filter)) {
            if ($type == '8-pool') {
                $filter = 'Average-Break-Run';
            } else {
                $filter = 'Highest-Break';
            }
        }

        switch ($filter) {
            case 'Average-Break-Run':
                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($item, $key) use ($type) {
                    $player_all_matches = $this->getPlayerMatches($type, $item);
                    $player_total_matches = $player_all_matches->count();
                    $player_break_and_run = $player_all_matches->sum(function ($match) use ($item) {
                        return $match->player_1 == $item->id ? $match->break_run_player_1 : $match->break_run_player_2;
                    });

                    return [
                        'name' => $item->name,
                        'value' => $player_total_matches == 0 ? 0 : round($player_break_and_run / $player_total_matches, 2)
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Break-Run':
                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($item, $key) use ($type) {
                    $player_all_matches = $this->getPlayerMatches($type, $item);
                    $player_break_and_run = $player_all_matches->sum(function ($match) use ($item) {
                        return $match->player_1 == $item->id ? $match->break_run_player_1 : $match->break_run_player_2;
                    });

                    return [
                        'name' => $item->name,
                        'value' => $player_break_and_run
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Highest-Break':
                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($item, $key) use ($type) {
                    $player_all_matches = $this->getPlayerMatches($type, $item);
                    $player_break_and_run = $player_all_matches->sum(function ($match) use ($item) {
                        return $match->player_1 == $item->id ? $match->break_run_player_1 : $match->break_run_player_2;
                    });

                    return [
                        'name' => $item->name,
                        'value' => $player_break_and_run
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Total-Frames-Won':
                $all_matches = Tournament::where('type', $type)->get();
                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($player, $key) use ($all_matches) {

                    $frames_won = $all_matches->sum(function ($match) use ($player) {
                        if ($match->player_1 == $player->id) {
                            return $match->score_player_1;
                        } elseif ($match->player_2 == $player->id) {
                            return $match->score_player_2;
                        } else {
                            return 0;
                        }
                    });

                    return [
                        'name' => $player->name,
                        'value' => $frames_won
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Total-Matches-Won':
                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($item, $key) use ($type) {
                    return [
                        'name' => $item->name,
                        'value' => Tournament::where('type', $type)
                            ->where('winner', $item->id)
                            ->count()
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Winning-Percentage':
                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($item, $key) use ($type) {
                    $player_all_matches = $this->getPlayerMatches($type, $item);
                    $player_total_matches = $player_all_matches->count();
                    $player_all_wins = $player_all_matches->where('winner', $item->id)->count();

                    return [
                        'name' => $item->name,
                        'value' => $player_total_matches == 0 ? 0 . '%' : round($player_all_wins / $player_total_matches * 100, 2) . '%'
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Winning-Streak':

                $data = Player::select(['id', 'name'])->toBase()->get()->map(function ($item, $key) use ($type) {
                    $player_all_matches = $this->getPlayerMatches($type, $item);

                    $player_winning_streak = 0;
                    $player_winning_streak_temp = 0;
                    foreach ($player_all_matches as $match) {
                        if ($match->winner == $item->id) {
                            $player_winning_streak_temp++;
                        } else {
                            $player_winning_streak_temp = 0;
                        }

                        if ($player_winning_streak_temp > $player_winning_streak) {
                            $player_winning_streak = $player_winning_streak_temp;
                        }
                    }

                    return [
                        'name' => $item->name,
                        'value' => $player_winning_streak
                    ];
                });
                $data = $data->sortByDesc('value')->values()->all();
                break;
            case 'Total-Prize-Money':
                $data = Player::latest('earnings')->get()->map(function ($item, $key) {
                    return [
                        'name' => $item->name,
                        'value' => $item->earnings . ' MAD',
                    ];
                });
                break;
        }

        return view('pages.stats.index', compact('data'));
    }

    function getPlayerMatches($type, $player)
    {

        return Tournament::where('type', $type)
            ->whereNotNull('winner')
            ->where(function ($q) use ($player) {
                $q->where('player_1', $player->id)
                    ->orWhere('player_2', $player->id);
            })->get();


    }

    public function get_players()
    {
        $players = Player::select(['id', 'name'])->latest()->get();
        return response()->json($players);
    }

    public function create_tournament()
    {
        $players = Player::latest()->get();
        return view('pages.matches.tournament.add', compact('players'));
    }

    public function store_tournament()
    {
        $service = new TournamentBracketService();
        $service->create_brackets($data = request()->all());
        return;

        $player1 = request('player1');
        $player2 = request('player2');
        $no_of_players = request('number_of_players');
        $type = request('type');

        $round = $this->get_round($no_of_players);



        for ($i = 0; $i < request('total_matches'); $i++) {

            Tournament::create([
                'player_1' => $player1[$i],
                'player_2' => $player2[$i],
                'tournament' => request('title'),
                'rules' => request('rules'),
                'year' => now(),
                'type' => $type,
                'status' => Tournament::KEY_ACTION_CREATED,
                'round' => $round,

                'score_player_1' => 0,
                'score_player_2' => 0,
                'level' => 1,
                'table' => $i+1
            ]);

        }

        return response()->json(request()->all());
    }



    public function tournament_draw($tournament_title)
    {
        //First
        $tournaments = Tournament::where('tournament', $tournament_title)->where('level', 1)->get();

        $first_tournament = $tournaments->first();

        $output = $this->get_mapped_tournaments($tournaments, [] ); //[mapped, winners]
//        dd($tournaments, $output[0]);
        $tournaments = $output[0];
        $tournaments_second_round_winners = $output[1];

        if($tournaments_second_round_winners){
            //Second
            $second_round = $this->pre_processing_array_for_further_tournaments($tournaments_second_round_winners);
            $second_round[0]['round'] = $this->get_round(count($second_round) * 2);;

            $pending_tournaments = $tournaments->where('player_2', '!=', '0')->where('winner', null)->count();
            // if($pending_tournaments == 0){ //winner is selected for all the tournaments
                $this->create_further_tournaments_based_on_previous_winners($second_round, $first_tournament, 2);
            // }

            $second_round_tournaments = Tournament::where('tournament', $tournament_title)->where('level', 2)->get();
            if(count($second_round_tournaments) > 0){
                $output = $this->get_mapped_tournaments($second_round_tournaments, [] );
                $second_round = $output[0];

                $tournaments_third_round_winners = $output[1];
            }
        }
        else{
            $second_round = [];
        }



        if(isset($tournaments_third_round_winners)){
            //Third
            $third_round = $this->pre_processing_array_for_further_tournaments($tournaments_third_round_winners);

            $pending_tournaments = $second_round_tournaments->where('winner', null)->count();
            // if($pending_tournaments == 0){
                $output = $this->create_further_tournaments_based_on_previous_winners($third_round, $first_tournament, 3);
            // }

            $third_round_tournaments = Tournament::where('tournament', $tournament_title)->where('level', 3)->get();
            if($third_round_tournaments){
                $output = $this->get_mapped_tournaments($third_round_tournaments, [] );
                $third_round = $output[0];
                $tournaments_fourth_round_winners = $output[1];
            }
        }
        else{
            $third_round = [];
        }




        if(isset($tournaments_fourth_round_winners)){
            //Fourth
            $fourth_round = $this->pre_processing_array_for_further_tournaments($tournaments_fourth_round_winners);

            $pending_tournaments = $third_round_tournaments->where('winner', null)->count();
            // if($pending_tournaments == 0){
                $output = $this->create_further_tournaments_based_on_previous_winners($fourth_round, $first_tournament, 4);
            // }

            $fourth_round_tournaments = Tournament::where('tournament', $tournament_title)->where('level', 4)->get();
            if($fourth_round_tournaments){
                $output = $this->get_mapped_tournaments($fourth_round_tournaments, [] );
                $fourth_round = $output[0];
                $tournaments_fifth_round_winners = $output[1];
            }
        }
        else{
            $fourth_round = [];
        }



        if(isset($tournaments_fifth_round_winners)){
            //Fifth
            $fifth_round = $this->pre_processing_array_for_further_tournaments($tournaments_fifth_round_winners);

            $pending_tournaments = $fourth_round_tournaments->where('winner', null)->count();
            // if($pending_tournaments == 0){
                $output = $this->create_further_tournaments_based_on_previous_winners($fifth_round, $first_tournament, 5);
            // }

            $fifth_round_tournaments = Tournament::where('tournament', $tournament_title)->where('level', 5)->get();
            if($fifth_round_tournaments){
                $output = $this->get_mapped_tournaments($fifth_round_tournaments, [] );
                $fifth_round = $output[0];
                $tournaments_fifth_round_winners = $output[1];
            }
        }
        else{
            $fifth_round = [];
        }

        return view('pages.matches.tournament.tournament-draw', get_defined_vars());
    }

    public function get_bracket_data(Request $request)
    {
        $tournament_title = $request->tournament_title;
        $level = $request->level;

        $tournaments = Tournament::where('tournament', $tournament_title)
            ->where('level', $level)
            ->get();

        $data = [];

        foreach ($tournaments as $tournament) {

            $winner = null;
            if ($tournament->status != Tournament::ACTION_CREATED) {
                if ($tournament->score_player_1 > $tournament->score_player_2) {
                    $winner = $tournament->player_1;
                } elseif ($tournament->score_player_2 > $tournament->score_player_1) {
                    $winner = $tournament->player_2;
                }
            }

            $data[] = [
                'id' => $tournament->id,

                'player_1_name' => get_player_name_draw($tournament->player_1),
                'player_1_id' => $tournament->player_1,

                'player_2_name' => get_player_name_draw($tournament->player_2),
                'player_2_id' => $tournament->player_2,

                'score_player_1' => $tournament->status == Tournament::ACTION_CREATED
                    ? '-'
                    : $tournament->score_player_1,

                'score_player_2' => $tournament->player_2 == 0
                    ? '-'
                    : ($tournament->status == Tournament::ACTION_CREATED
                        ? '-'
                        : $tournament->score_player_2),

                'winner' => $winner,
                'round' => $tournament->round,
            ];
        }

        return response()->json($data);
    }


    function get_mapped_tournaments($tournaments, $second_array)
    {
        $tournaments = $tournaments->map(function ($item, $key) use (&$second_array) {
            $winner = $item->player_2 == 0 ? $item->player_1 : $item->winner;
            $second_array[] = $winner;
            return [
                'id' => $item->id,
                'player_1' => get_player_name_draw($item->player_1),
                'player_1_id' => $item->player_1,

                'player_2' => get_player_name_draw($item->player_2),
                'player_2_id' => $item->player_2,

                'score_player_1' => $item->status == Tournament::ACTION_CREATED ? '-' : $item->score_player_1,
                'score_player_2' => $item->player_2 == 0 ? '-' : ($item->status == Tournament::ACTION_CREATED ? '-' : $item->score_player_2),
                'winner' => $winner,
                'round' => $item->round,
            ];
        });

        // Check if the collection has only one item
        if ($tournaments->count() == 1) {
            // Duplicate the item with null values for each key
            $original_item = $tournaments->first();
            $duplicated_item = array_fill_keys(array_keys($original_item), null);

            // Add the duplicated item to the collection
            $tournaments->push($duplicated_item);
        }

         return [$tournaments, $second_array];
    }

    function create_further_tournaments_based_on_previous_winners($second_round, $first_tournament, $level){

        $round = $this->get_round(count($second_round) * 2);
        foreach ($second_round as $tournament){

            if (is_null($tournament['player_1_id']) || is_null($tournament['player_2_id'])) {
                continue;
            }

            Tournament::firstOrCreate(
                [
                    'player_1' => $tournament['player_1_id'],
                    'player_2' => $tournament['player_2_id'],
                    'tournament' => $first_tournament->tournament
                ],
                [
                    'player_1' => $tournament['player_1_id'],
                    'player_2' => $tournament['player_2_id'],
                    'tournament' => $first_tournament->tournament,
                    'rules' => $first_tournament->rules,
                    'year' => now(),
                    'type' => $first_tournament->type,
                    'status' => Tournament::KEY_ACTION_CREATED,
                    'round' => $round,
                    'score_player_1' => 0,
                    'score_player_2' => 0,
                    'level' => $level
                ]);
        }
    }

    function pre_processing_array_for_further_tournaments($tournaments_third_round_winners){
        $next_round = [];
        $temp_array = [];
        foreach ($tournaments_third_round_winners as $key => $tournament) {

            $temp_array['winner'] = null;
            if ($key % 2 == 0) {
                $temp_array['player_1'] = get_player_name($tournament);
                $temp_array['player_1_id'] = $tournament;
                $temp_array['score_player_1'] = '-';

            } else {
                $temp_array['player_2'] = get_player_name($tournament);
                $temp_array['player_2_id'] = $tournament;
                $temp_array['score_player_2'] = '-';
                $next_round[] = $temp_array;
                $temp_array = [];
            }


        }
        return $next_round;
    }

    public function get_round($no_of_players){
        //if number is between specific range
        $round = '';

        if ($no_of_players == 2) {
            $round = 'Final';
        } elseif ($no_of_players >= 2 && $no_of_players <= 4) {
            $round = 'Semi Final';
        } elseif ($no_of_players >= 5 && $no_of_players <= 8) {
            $round = 'Quarter Final';
        } elseif ($no_of_players >= 9 && $no_of_players <= 16) {
            $round = 'Round of 16';
        } elseif ($no_of_players >= 17 && $no_of_players <= 32) {
            $round = 'Round of 32';
        } elseif ($no_of_players >= 33 && $no_of_players <= 64) {
            $round = 'Round of 64';
        } elseif ($no_of_players >= 65 && $no_of_players <= 128) {
            $round = 'Round of 128';
        }
        return $round;
    }
}
