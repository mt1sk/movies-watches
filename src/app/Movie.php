<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function watches()
    {
        return $this->morphMany(Watch::class, 'watchable');
    }
}
