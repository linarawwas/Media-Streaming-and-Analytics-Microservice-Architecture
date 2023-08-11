<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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
     * Get a signed URL for a private episode with a maximum time to live of 1 hour.
     *
     * @param  int  $episode_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSignedUrl($episode_id)
    {
        $episode = Episode::findOrFail($episode_id);
    
        if ($episode->status !== 'private') {
            return response()->json(['error' => 'Episode is not private'], 400);
        }
    
        // Generate a signed URL with a 1-hour expiration time
        $url = Storage::disk('s3')->temporaryUrl(
            $episode->mp3_url,
            now()->addHour(),
            ['ResponseContentDisposition' => 'attachment; filename=' . $episode->mp3_url]
        );
    
        return response()->json(['signed_url' => $url], 200);
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
}
