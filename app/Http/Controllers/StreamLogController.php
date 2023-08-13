<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\StreamLog;
use App\Models\User;
use App\Jobs\CreateStreamLog;

class StreamLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['getEpisodeLogs', 'getAllLogs']);
    }
    public function logStream(User $user, Episode $episode)
    {
        // Dispatch the CreateStreamLog job to create the stream log entry
        CreateStreamLog::dispatch($user, $episode);

        return response()->json(['message' => 'Stream log creation dispatched']);
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
