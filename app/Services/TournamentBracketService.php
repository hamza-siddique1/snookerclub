<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Support\Facades\DB;

class TournamentBracketService
{
    public function create_brackets($data)
    {
        DB::transaction(function () use ($data) {

            /*
            ---------------------------------
            1. Create Tournament
            ---------------------------------
            */

            $tournament = Tournament::create([
                'title' => $data['title'],
                'total_players' => $data['number_of_players'],
                'type' => $data['type'],
                'status' => 'pending',
                'year' => now()->year
            ]);

            $playersCount = $data['number_of_players'];

            /*
            ---------------------------------
            2. Calculate structure
            ---------------------------------
            */

            $totalRounds = log($playersCount, 2);
            $matchesPerRound = $playersCount / 2;

            $roundMatches = [];

            /*
            ---------------------------------
            3. Create ALL matches
            ---------------------------------
            */

            $matchNumber = 1;

            for ($round = 1; $round <= $totalRounds; $round++) {

                for ($i = 1; $i <= $matchesPerRound; $i++) {

                    $match = TournamentMatch::create([
                        'tournament_id' => $tournament->id,
                        'round' => $round,
                        'match_number' => $matchNumber,
                        'status' => 'pending',
                        'table_no' => $matchNumber,
                    ]);

                    $roundMatches[$round][] = $match;

                    $matchNumber++;
                }

                $matchesPerRound = $matchesPerRound / 2;
            }

            /*
            ---------------------------------
            4. Link matches to next round
            ---------------------------------
            */

            for ($round = 1; $round < $totalRounds; $round++) {

                foreach ($roundMatches[$round] as $index => $match) {

                    $nextMatchIndex = floor($index / 2);

                    $nextMatch = $roundMatches[$round + 1][$nextMatchIndex];

                    $match->next_match_id = $nextMatch->id;
                    $match->next_match_slot = $index % 2 == 0 ? 1 : 2;

                    $match->save();
                }
            }

            /*
            ---------------------------------
            5. Assign Round 1 players
            ---------------------------------
            */

            foreach ($roundMatches[1] as $index => $match) {

                $match->player1_id = $data['player1'][$index];
                $match->player2_id = $data['player2'][$index];

                $match->save();
            }

        });
    }
}
