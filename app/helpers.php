<?php

use Illuminate\Support\Facades\Storage;

function order_activity($title , $order) {
    $order->activities()->create([
        "order_id" => $order->id,
        "title" => $title,

    ]);
}

function get_player_name($id ) {

    $player = \App\Models\Player::select('name')
        ->where('id',$id )
        ->first();

    try {
        return $player['name'];
    }
    catch (\Exception $e) {
        return "";
    }

}

function get_player_slug($id ) {

    $player = \App\Models\Player::select('slug')
        ->where('id',$id )
        ->first();

    try {
        return $player['slug'];
    }
    catch (\Exception $e) {
        return "";
    }

}

function get_player_name_draw($id ) {

    $player = \App\Models\Player::select('name')
        ->where('id',$id )
        ->first();

    try {
        return $player['name'];
    }
    catch (\Exception $e) {
        return "Bye";
    }

}

function get_img_url($key)
{
    if (str_contains($key, 'https')) {
        return $key;
    } else {
        return "/players/" . $key;
    }

}
