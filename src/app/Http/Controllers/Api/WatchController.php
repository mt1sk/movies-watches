<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateWatchRequest;
use App\Watch;
use App\Http\Resources\Api\Watch as WatchResource;
use Illuminate\Http\Request;

class WatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Watch  $watch
     * @return \Illuminate\Http\Response
     */
    public function show(Watch $watch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateWatchRequest  $request
     * @param  \App\Watch  $watch
     * @return \App\Http\Resources\Api\Watch
     */
    public function update(UpdateWatchRequest $request, Watch $watch)
    {
        unset($watch->watchable);
        $watch->year = $request->get('year', $watch->year);
        $watch->count = $request->get('count', $watch->count);
        $watch->save();
        return new WatchResource($watch);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Watch  $watch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Watch $watch)
    {
        //
    }
}
