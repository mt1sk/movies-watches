<?php

namespace App\Movies;


use Illuminate\Database\Eloquent\Collection;

interface MovieSearch
{
    public function search(string $query): Collection;
}