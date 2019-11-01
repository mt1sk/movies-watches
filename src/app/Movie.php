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
        return base64_encode(mb_strtolower($name ?? $this->name));
    }

    public function setNameAttribute($name) {
        /**
         * influences on storing movie
         */
        $this->attributes['name'] = preg_replace('~\s{2,}~', ' ', $name);
    }
}
