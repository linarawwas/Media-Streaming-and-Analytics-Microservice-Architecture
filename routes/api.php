<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\StreamLogController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
    // for the User controller:
    // Delete a user by ID
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::controller(EpisodeController::class)->group(function () {
    // authenticated routes: 
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Add an episode to the database
        Route::post('/add-episode','add_episode');
        // Make an episode private
        Route::put('/make-episode-private/{id}', 'make_episode_private');
        // Get a signed URL for a private episode
        //didn't finish it due to lack of access to credit card ->  aws s3 service
        Route::get('/get-signed-url/{episode_id}','getSignedUrl'); 
        // Get information about all episodes
        Route::get('/episodes', 'getAllEpisodes');
        // Public Media Streaming Service for all Visitors prior to logging In/ register: 
        Route::get('/stream-episode/{episode_id}','streamEpisode');
    });

    });

    Route::middleware(['auth:sanctum'])->group(function () {
        // View All Logs of All Episodes
        Route::get('/stream-logs', [StreamLogController::class, 'getAllLogs']);
    
        // View All Logs of a Specific Episode
        Route::get('/episode/{episode_id}/stream-logs', [StreamLogController::class, 'getEpisodeLogs']);
    
        // View All Logs of Authenticated User's Episodes
        Route::get('/user/stream-logs', [StreamLogController::class, 'getUserLogs']);
    });