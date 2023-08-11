<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'episode_id', 'user_id', 'timestamp', // Add other logging fields as needed
    ];

    /**
     * Get the episode that this stream log belongs to.
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    /**
     * Get the user associated with this stream log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
