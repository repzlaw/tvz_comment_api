<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Comments\TeamCommentController;
use App\Http\Controllers\Comments\PlayerCommentController;
use App\Http\Controllers\Comments\ReportCommentController;
use App\Http\Controllers\ReportedController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comment',[CommentsController::class,'index']);
Route::get('/store',[CommentsController::class,'store']);

//comment routes
Route::prefix('/v1/comments')->middleware('ipcheck')->name('comment.')->group(function(){
    Route::get('/', [CommentsController::class,'getComments'])->name('get');
    Route::post('/save-news-comment', [CommentsController::class,'storeNewsComment'])->name('store-news');
    Route::post('/save-news-reply', [CommentsController::class,'storeNewsReply'])->name('store-reply');
    Route::post('/save-player-comment', [PlayerCommentController::class,'storePlayerComment'])->name('store-player-comment');
    Route::post('/save-player-reply', [PlayerCommentController::class,'storePlayerReply'])->name('store-player-reply');
    Route::post('/save-team-comment', [TeamCommentController::class,'storeTeamComment'])->name('store-team-comment');
    Route::post('/save-team-reply', [TeamCommentController::class,'storeTeamReply'])->name('store-team-reply');
    Route::get('/upvote-comment', [CommentsController::class,'upvoteComment'])->name('upvote');
    Route::get('/individual', [CommentsController::class,'getUserComment'])->name('single.user')->middleware(['verified']);
    Route::post('/report-news-comment', [ReportCommentController::class,'reportNewsComment'])->name('report-news-comment');
    Route::post('/report-team-comment', [ReportCommentController::class,'reportTeamComment'])->name('report-team-comment');
    Route::post('/report-player-comment', [ReportCommentController::class,'reportPlayerComment'])->name('report-player-comment');

});

//reported routes
Route::prefix('/reported')->name('reported.')->middleware(['ipcheck'])->group(function(){
    Route::get('/news-comment', [ReportedController::class,'getNewsComment'])->name('news.get');
    Route::get('/players-comment', [ReportedController::class,'getPlayersComment'])->name('player.get');
    Route::get('/teams-comment', [ReportedController::class,'getTeamsComment'])->name('team.get');

});
