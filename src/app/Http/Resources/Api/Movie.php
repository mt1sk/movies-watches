<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class Movie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hash' => $this->hash,
            'duration' => $this->duration,
            /*'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),*/
            'watches' => Watch::collection($this->whenLoaded('watches')),
            'watches_total' => $this->when(isset($this->watches_total), $this->watches_total),
        ];
    }
}
