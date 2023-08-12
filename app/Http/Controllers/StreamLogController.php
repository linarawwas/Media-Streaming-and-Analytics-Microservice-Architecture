<?php
namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\StreamLog;
use Illuminate\Http\Request;

class StreamLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['getEpisodeLogs', 'getAllLogs']);
    }
    public function logStream(Request $request, Episode $episode)
    {
        // Create a stream log entry
        StreamLog::create([
            'user_id' => auth()->id(),
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
        $logs = StreamLog::where('episode_id', $episode->id)->with('user', 'episode')->get();

        return response()->json(['logs' => $logs]);
    }
    public function getUserLogs()
    {
        $user = auth()->user();
        $logs = StreamLog::where('user_id', $user->id)->with('user', 'episode')->get();

        return response()->json(['logs' => $logs]);
    }
}
