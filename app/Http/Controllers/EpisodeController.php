<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EpisodeController extends Controller
{
    /**
     * Add an episode to the database.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
/**
 * Add an episode to the database.
 *
 * @param  Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function add_episode(Request $request)
{
    // Validate the request data
    $request->validate([
        'mp3_url' => 'required|string',
        'name' => 'required|string',
        'author' => 'required|string',
        // Add other validation rules as needed
    ]);

    // Create a new episode
    $episode = Episode::create([
        'mp3_url' => $request->mp3_url,
        'name' => $request->name,
        'author' => $request->author,
        // Set other fields as needed
    ]);

    return response()->json(['message' => 'Episode added successfully', 'episode' => $episode], 201);
}

/**
 * Make an episode private (admin only).
 *
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function make_episode_private($id)
{
    // Find the episode
    $episode = Episode::findOrFail($id);

    // Check if the authenticated user is an admin
    if (!auth()->user()->isAdmin()) {
        return response()->json(['error' => 'Only admins can mark episodes as private'], 403);
    }

    // Update the status to private
    $episode->update(['status' => 'private']);

    return response()->json(['message' => 'Episode marked as private', 'episode' => $episode], 200);
}
        /**
     * Get information about all episodes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEpisodes()
    {
        $episodes = Episode::all();

        return response()->json(['episodes' => $episodes], 200);
    }
    /**
     * Stream an episode.
     *
     * @param  int  $episode_id
     * @return mixed
     */    
    public function streamEpisode($episode_id)
    {
        // Find the episode
        $episode = Episode::findOrFail($episode_id);
    
        // Get the episode's MP3 URL
        $mp3Url = $episode->mp3_url;
    
        // Check if the episode is private and the user is not authenticated
        if ($episode->status === 'private' && !auth()->check()) {
            return response()->json(['error' => 'Private episode, authentication required'], 401);
        }
    
        // If the user is authenticated, log the stream
        if (auth()->check()) {
            app(StreamLogController::class)->logStream(request(), $episode);
        }
    
        // Create the StreamedResponse
        $streamResponse = new StreamedResponse(function () use ($mp3Url) {
            readfile($mp3Url);
        });
    
        // Set the content headers
        $streamResponse->headers->set('Content-Type', 'audio/mpeg');
        $streamResponse->headers->set('Content-Disposition', 'inline; filename="episode.mp3"');
    
        return $streamResponse;
    }
    
}
