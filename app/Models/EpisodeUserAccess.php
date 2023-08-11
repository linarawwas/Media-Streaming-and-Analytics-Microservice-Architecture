<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpisodeUserAccess extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'episode_id', 'user_id',
    ];

    /**
     * Get the episode for which this access is granted.
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    /**
     * Get the user for whom this access is granted.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
