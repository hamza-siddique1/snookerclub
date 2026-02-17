<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerHistory;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/test', function() {
   dd(now());

   // new branch
});

Route::get('/', [PlayerHistory::class, 'index_front'])->name('homepage.front');

Route::get('scores', [TournamentController::class, 'results'])->name('tournament.results');
Route::get('api/scores', [TournamentController::class, 'results_api']);
Route::get('scores/{match}', [TournamentController::class, 'results_details'])->name('tournament.results.id');
Route::get('api/scores/{match}', [TournamentController::class, 'results_details_frames_api']);
Route::get('contact', [TournamentController::class, 'contact'])->name('tournament.contact');
Route::get('about', [TournamentController::class, 'about'])->name('tournament.about');
Route::post('email', [TournamentController::class, 'send_email'])->name('contact.send_email');

//Ranking
Route::get('stats', [TournamentController::class, 'stats'])->name('tournament.stats');

Route::get('results2', [TournamentController::class, 'results2'])->name('tournament.results2');

//Tournament Brackets
Route::get('draw/{tournament}', [TournamentController::class, 'tournament_draw'])->name('tournaments.draw');

Route::group(['middleware' => ['auth']], function () {

    Route::group([
        'prefix' => 'profile',
    ], function () {
        Route::get('/{tab?}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('account', [ProfileController::class, 'account'])->name('profile.account');

    });

//    Route::get('/home', [PlayerHistory::class, 'index'])->name('homepage.index');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::impersonate();

    Route::resource('matches', TournamentController::class);
    Route::get('tournaments/create', [TournamentController::class, 'create_tournament'])->name('tournaments.create_tournament');
    Route::get('api/players', [TournamentController::class, 'get_players'])->name('tournaments.get_players');
    Route::post('tournaments/create', [TournamentController::class, 'store_tournament'])->name('tournaments.store_tournament');



    Route::group(
        [
            'middleware' => 'admin',
            'prefix' => 'admin',
            'as' => 'admin.'
        ], function () {

        Route::resource('players', PlayerController::class);
        Route::resource('users', UsersController::class);
        Route::post('password/{user}', [UsersController::class, 'password_update'])->name('user.password_update');



    });

});

// New
Route::get('/reset', function () {
            //dd('Nothing to do');

            if (env('APP_ENV') != 'local') {
                dd('Nothing to do');
                return;
            }
            \Artisan::call('migrate:fresh');
            \Artisan::call('db:seed');
            \Artisan::call('optimize:clear');
            dd('Database cleared');
        });
