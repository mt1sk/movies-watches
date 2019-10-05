<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    public function watchable()
    {
        return $this->morphTo();
    }
}
