<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Location;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['locations'] = Location::all();
        return view('admin.contents.locations', $data);
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
    public function store(Request $request)
    {
        $location = new Location();
        $location->region = $request->region;
        $location->city = $request->city;
        $location->street = $request->street;
        $location->save();

        if($location){
            return response()->json(array('success' => true, 'msg' => 'New location created!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'Something went wrong on the system, Please try again!'));
        }
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
    public function update(Request $request)
    {
        $location = Location::where('id', $request->id)->first();
        $location->region = $request->region;
        $location->city = $request->city;
        $location->street = $request->street;
        $location->save();

        if($location){
            return response()->json(array('success' => true, 'msg' => 'Llocation updated!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'Something went wrong on the system, Please try again!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $location = Location::where('id', $request->id);
        $location->delete();

        if($location){
            return response()->json(array('success' => true, 'msg' => 'Location has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Page, please try again!'));
        }
    }

    public function getLocationDataJSON(Request $request){
        $location = Location::where('id',$request->id)->first();
        return response()->json($location);
    }
}
