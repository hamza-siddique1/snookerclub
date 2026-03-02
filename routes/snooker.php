<?php

use App\Http\Controllers\SnookerMatchController;
use Illuminate\Support\Facades\Route;

Route::prefix('snooker')->group(function () {
    // Setup page
    Route::get('/setup', [SnookerMatchController::class, 'setup'])
        ->name('snooker.setup');

    Route::get('/matches', [SnookerMatchController::class, 'index'])
        ->name('snooker.matches');

    // Create match
    Route::post('/create', [SnookerMatchController::class, 'create'])
        ->name('snooker.create');

    // Display pages
    Route::get('/{match}/lcd', [SnookerMatchController::class, 'lcd'])
        ->name('snooker.lcd');

    Route::get('/{match}/remote', [SnookerMatchController::class, 'remote'])
        ->name('snooker.remote');

    // API Endpoints (for polling and AJAX)
    Route::group(['prefix' => 'api'], function () {
        // Get current match data
        Route::get('/{match}/data', [SnookerMatchController::class, 'getMatchData'])
            ->name('snooker.api.data');

        // Match controls
        Route::post('/{match}/add-points', [SnookerMatchController::class, 'addPoints'])
            ->name('snooker.api.add-points');

        Route::post('/{match}/switch-player', [SnookerMatchController::class, 'switchPlayer'])
            ->name('snooker.api.switch-player');

        Route::post('/{match}/reset-break', [SnookerMatchController::class, 'resetBreak'])
            ->name('snooker.api.reset-break');

        Route::post('/{match}/end-frame', [SnookerMatchController::class, 'endFrame'])
            ->name('snooker.api.end-frame');

        Route::post('/{match}/undo', [SnookerMatchController::class, 'undo'])
            ->name('snooker.api.undo');

        Route::post('/{match}/reset', [SnookerMatchController::class, 'resetMatch'])
            ->name('snooker.api.reset');

        Route::post('/{match}/status', [SnookerMatchController::class, 'updateStatus'])
            ->name('snooker.api.status');

        Route::delete('/{match}/delete', [SnookerMatchController::class, 'updateStatus'])
            ->name('snooker.api.delete');
    });
});
