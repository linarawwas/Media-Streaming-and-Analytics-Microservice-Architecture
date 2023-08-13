<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Episode;
use App\Models\StreamLog;
use App\Models\User;

class CreateStreamLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $episode;

    public function __construct(User $user, Episode $episode)
    {
        $this->user = $user;
        $this->episode = $episode;
    }

    public function handle()
    {
        StreamLog::create([
            'user_id' => $this->user->id,
            'episode_id' => $this->episode->id,
        ]);
    }
}
