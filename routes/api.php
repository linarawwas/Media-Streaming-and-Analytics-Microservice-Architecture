<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    //for the episode controller:

    // Add an episode to the database
    Route::post('/add-episode', [EpisodeController::class, 'add_episode']);
    // Make an episode private
    Route::put('/make-episode-private/{id}', [EpisodeController::class, 'make_episode_private']);
    // Get a signed URL for a private episode
    Route::get('/get-signed-url/{episode_id}', [EpisodeController::class, 'getSignedUrl']);
    // Get information about all episodes
    Route::get('/episodes', [EpisodeController::class, 'getAllEpisodes']);

    // for the User controller:

    // Delete a user by ID
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
});

