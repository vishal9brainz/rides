<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Ride;
use JWTAuth;
use DB;
use App\Http\Resources\Ride as RideCollection;
use App\Http\Resources\UserCollection as UserRideCollection;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
class RideController extends Controller
{

	protected $user;
	public function __construct()
		{
    		$this->user = JWTAuth::parseToken()->authenticate();
		}
    public function store(Request $request)
		{
			$rides = new Ride();
		    $rides->rides_DateTime = Carbon::parse($request->date." " .$request->time)->format('Y-m-d H:i:s');
		    $rides->from_place = $request->from_place;
		    $rides->to_place=$request->to_place;
		    $rides->routes=$request->routes;
		    $rides->seats=$request->seats;
		    if ($this->user->rides()->save($rides))
		    {
		    	$rides=Ride::select('id','rides_DateTime','from_place','to_place','routes','seats')->where('user_id',$this->user->id)->orderBy('id','desc')->get();
		    	// $rides=Ride::with('users')->whereDate('rides_DateTime',Carbon::parse($request->date." " .$request->time)->format('Y-m-d'))->get();
		        return response()->json([
		            'success' => true,
		            'Message' =>'Rides Add Successfully',
		            'rides' =>UserRideCollection::collection($rides),
		        ]);
		    }
		}
	public function update(Request $request,$id)
	{
		$rides = $this->user->rides()->find($id);
		$updated = $rides->fill(array_merge($request->except('date','time'),['rides_DateTime'=>Carbon::parse($request->date." " .$request->time)->format('Y-m-d H:i:s')]))->save();
		if(count($updated)>0){
			$rides=Ride::with('users')->where('id',$id)->first();
			 return response()->json([
		            'success' => true,
		            'Message' =>'Rides Updated Successfully',
		            'rides' => new RideCollection($rides),
		        ]);
		}
	}
	public function destroy($id)
	{
		$rides = $this->user->rides()->find($id);
		$deleted_Rides=$rides;
		if ($rides->delete()) {
		        return response()->json([
		            'success' => true,
		            'Message' => 'Rides Deleted SuccessFully',
		            'deleted_Rides'=> new RideCollection($deleted_Rides)
		        ]);
		    }
	}
	public function getMyRides()
	{
		$rides=$this->user->rides()->get();
		if(count($rides)>0){
			return response()->json([
		            'success' => true,
		            'Message' => 'Rides Fetch SuccessFully',
		            'Rides'=> UserRideCollection::collection($rides)
		        ]);
		}
		return response()->json([
		    'success' => true,
		    'Message' => 'Sorry No Data Available',
		]);

	}
}
