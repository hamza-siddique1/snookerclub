<?php

use App\Http\Controllers\PlayerHistory;
use App\Http\Controllers\PlayerRankingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PlayerHistory::class, 'index_front'])->name('homepage.front');

Route::get('/leaderboard', [PlayerRankingController::class, 'leaderboard']);

