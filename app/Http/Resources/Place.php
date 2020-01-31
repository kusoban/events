<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Place extends JsonResource
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
            'address' => $this->address,
            'types' => $this->types()->get()->map( function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            }),
            'events' => $this->events()->get()->map( function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            } ),
        ];
    }
}
