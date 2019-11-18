<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Ride;
use App\Http\Resources\Ride as RideCollection;
use Carbon\Carbon;
use App\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class ListController extends Controller
{
    public function getList(Request $request)
		{
			$this->validateLocation($request->location_id);
			$rides=Ride::with('users')->whereDate('rides_DateTime','>=',Carbon::today())->where('location_id',$request->location_id)->orderBy('created_at','desc')->get();
			$response=count($rides->toArray());
			if($response>0){
				return response()->json([
		            'success' => true,
		            'Message' =>'Rides Fetch Successfully',
		            'rides' =>RideCollection::collection($rides),
		        ]);
			}else{
				return response()->json([
		            'success' => false,
		            'Message' => 'Sorry No Routes Found..'
		        ]);
			}
		}
		public function findRoute(Request $request)
		{
			$rides=Ride::with('users')->where('from_place',$request->from_place)->where('to_place',$request->to_place)->whereDate('rides_DateTime',Carbon::parse($request->date." " .$request->time)->format('Y-m-d'))->get();
			if(count($rides)>0){
				return response()->json([
		            'success' => true,
		            'Message' =>'Rides Fetch Successfully',
		            'rides' =>RideCollection::collection($rides),
		        ]);

			}
			return response()->json([
		            'success' => false,
		            'Message' =>'Sorry No Route Founds',
		        ]);
		}
		public function validateLocation($location)
		{
			$locations=Ride::where('location_id',$location)->count();
			if($locations>0){
				return;
			}else{
				echo json_encode(['success'=>false,'message'=>'Location Not Available']);
				exit();
		}
	}
}
