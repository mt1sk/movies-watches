<?php

namespace App\Movies;


use App\Movie;
use Illuminate\Database\Eloquent\Collection;

class EloquentSearch implements MovieSearch
{
    public function search(string $query): Collection
    {
        $builder = Movie::query()
            ->where('name', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc');
        return $builder->get();
    }
}