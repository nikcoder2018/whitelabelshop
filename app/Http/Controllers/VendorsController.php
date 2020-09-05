<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\User;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['vendors'] = User::where('role', 'vendor')->get();
        return view('admin.contents.users-vendors',$data);
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
    public function store(StoreVendorRequest $request)
    {
        $validated = $request->validated();

        $vendor = new User();
        $vendor->shop_name = $validated['shop_name'];
        $vendor->email = $validated['email'];
        $vendor->firstname = $validated['firstname'];
        $vendor->lastname = $validated['lastname'];
        $vendor->password = Hash::make($validated['password']);
        $vendor->role = 'vendor';
        $vendor->save();

        if($vendor){
            return response()->json(array('success' => true, 'msg' => 'New vendor created!'));
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
    public function update(UpdateVendorRequest $request)
    {
        $validated = $request->validated();

        $vendor = User::find($request->id);
        $vendor->shop_name = $validated['shop_name'];
        $vendor->email = $validated['email'];
        $vendor->firstname = $validated['firstname'];
        $vendor->lastname = $validated['lastname'];
        $vendor->save();

        if($vendor){
            return response()->json(array('success' => true, 'msg' => 'Vendor updated!'));
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
        $vendor = User::where('id', $request->id);
        $vendor->delete();

        if($vendor){
            return response()->json(array('success' => true, 'msg' => 'Vendor has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Vendor, please try again!'));
        }
    }

    public function getVendorDataJSON(Request $request){
        $vendor = User::find($request->id);
        return response()->json($vendor);
    }
}
