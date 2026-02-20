<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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


    public function store(Request $request)
    {
        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $image_1_name = time() . '_1.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('players'), $image_1_name);
        } else {
            $image_1_name = null;
        }

        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $image_2_name = time() . '_2.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('players'), $image_2_name);
        } else {
            $image_2_name = null;
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
