<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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

    public function getHash($name = null)
    {
        return Hash::make(mb_strtolower($name ?? $this->name));
    }
}
