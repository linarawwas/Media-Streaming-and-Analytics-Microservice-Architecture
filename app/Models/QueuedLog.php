<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueuedLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stream_log_id',
    ];

    /**
     * Get the stream log associated with this queued log.
     */
    public function streamLog()
    {
        return $this->belongsTo(StreamLog::class);
    }
}
