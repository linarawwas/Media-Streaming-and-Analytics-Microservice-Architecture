<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\StreamLog;
use App\Models\User;
use Illuminate\Http\Request;

class StreamLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['getEpisodeLogs', 'getAllLogs']);
    }
    public function logStream(User $user, Episode $episode)
    {
        // Create a stream log entry and associate it with the user and episode
        $streamLog = StreamLog::create([
            'user_id' => $user->id,
            'episode_id' => $episode->id,
        ]);
    
        return response()->json(['message' => 'Stream logged successfully']);
    }
    
    
    
    
    public function getAllLogs()
    {
        $logs = StreamLog::with('user', 'episode')->get();

        return response()->json(['logs' => $logs]);
    }

    public function getEpisodeLogs($episode_id)
    {
        $episode = Episode::findOrFail($episode_id);
        $logs = $episode->streamLogs()->with('user', 'episode')->get();

        return response()->json(['logs' => $logs]);
    }

    public function getUserLogs()
    {
        $user = auth()->user();

        $logs = $user->streamLogs()->with('user', 'episode')->get();

        return response()->json(['logs' => $logs]);
    }
}
