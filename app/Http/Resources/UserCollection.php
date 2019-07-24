<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
             'id'        =>$this->id,
            'dateTime'  =>(string) $this->rides_DateTime,
            'from_place'=>(string) $this->from_place,
            'to_place'  =>(string) $this->to_place,
            'no_of_seats'  =>(string) $this->seats,
            'routes'    =>[
                'route_list'    =>(string) $this->routes,
            ],
        ];
    }
}
