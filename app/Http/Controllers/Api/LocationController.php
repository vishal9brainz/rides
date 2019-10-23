<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use App\Http\Requests\LocationRequest;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success'   =>  true,
            'Message'   =>  'Location Fetch SuccessFully',
            'locations' =>  Location::select('id','name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        Location::create($request->only('name'));
        return response()->json([
            'success'   =>  true,
            'message'   => 'Location Add SuccessFully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
       $locations=Location::find($id);
       if($locations){
            $locations->update($request->only('name'));
            return response()->json([
                'success'   =>   true,
                'message'   =>  'Location Update SuccessFully',
                'locations' =>  $locations
            ]);
       }else{
       return response()->json(['success'=>false,'Message'=>'Location Id Not Avaialble in Our System Please Try To Different']);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $locations=Location::find($id);
       if($locations){
            $locations->delete();
            return response()->json([
                'success'   =>   true,
                'message'   =>  'Location Delete SuccessFully',
            ]);
       }else{
       return response()->json(['success'=>false,'Message'=>'Location Id Not Avaialble in Our System Please Try To Different']);
       }
    }
}
