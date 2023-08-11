<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignedUrl extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'episode_id', 'token', 'expiration_time',
    ];

    /**
     * Get the episode for which this signed URL is created.
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
