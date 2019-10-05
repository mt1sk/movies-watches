<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexMovieRequest;
use App\Http\Requests\Api\StoreMovieRequest;
use App\Http\Requests\Api\UpdateMovieRequest;
use App\Movie;
use App\Watch;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Movie as MovieResource;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\IndexMovieRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexMovieRequest $request)
    {
        $user = $request->user();
        $limit = $request->get('limit', $user->getPerPage());
        $movies = $user->movies()->orderBy('created_at', 'desc')->paginate($limit);
        return MovieResource::collection($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\StoreMovieRequest  $request
     * @return \App\Http\Resources\Api\Movie
     */
    public function store(StoreMovieRequest $request)
    {
        // TODO try to find by hash before creating a movie
        $movie = new Movie();
        $movie->name = $request->name;
        $movie->hash = $movie->getHash();
        if (!empty($request->duration)) {
            $movie->duration = $request->duration;
        }
        $movie->user()->associate($request->user());
        $movie->save();

        $watch = new Watch();
        if (!empty($request->year)) {
            $watch->year = $request->year;
        }
        if (!empty($request->count)) {
            $watch->count = $request->count;
        }
        $watch->watchable()->associate($movie);
        $watch->save();

        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \App\Http\Resources\Api\Movie
     */
    public function show(Movie $movie)
    {
        $movie->load('watches');
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateMovieRequest  $request
     * @param  \App\Movie  $movie
     * @return \App\Http\Resources\Api\Movie
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie->name = $request->get('name', $movie->name);
        $movie->duration = $request->get('duration', $movie->duration);
        $movie->save();
        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response(null, 204);
    }
}
