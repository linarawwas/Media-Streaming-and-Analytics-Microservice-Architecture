<?php
namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\StreamLog;
use Illuminate\Http\Request;

class StreamLogController extends Controller
{
    public function logStream(Request $request, Episode $episode)
    {
        // Create a stream log entry
        StreamLog::create([
            'user_id' => auth()->id(),
            'episode_id' => $episode->id,
        ]);

        return response()->json(['message' => 'Stream logged successfully']);
    }
}
