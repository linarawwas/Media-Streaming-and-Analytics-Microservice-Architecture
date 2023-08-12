<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamLog extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
