<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Location;
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
            'location'      =>Location::select('name','id')->where('id',$this->location_id)->first(),
            'routes'    =>[
                'route_list'    =>(string) $this->routes,
            ],
        ];
    }
}
