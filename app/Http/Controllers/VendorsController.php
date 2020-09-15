<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\User;
use App\VendorDetails;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['vendors'] = User::with('vendor_details')->where('role', 'vendor')->get();

        #return response()->json($data);
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
        $vendor->email = $validated['email'];
        $vendor->firstname = $validated['firstname'];
        $vendor->lastname = $validated['lastname'];
        $vendor->password = Hash::make($validated['password']);
        $vendor->role = 'vendor';
        $vendor->save();

        $vendor_details = new VendorDetails();
        $vendor_details->user_id = $vendor->id;
        $vendor_details->vendor_name = $validated['shop_name'];
        $vendor_details->vat = $validated['vat'];
        $vendor_details->address = $request->address;
        $vendor_details->region = $request->region;
        $vendor_details->city = $request->city;
        $vendor_details->phone = $request->phone;
        $vendor_details->contact_person_name = $request->contactperson;
        $vendor_details->contact_person_number = $validated['contactpersonnumber'];
        $vendor_details->subscription = $request->subscription;
        $vendor_details->save();

        if($vendor && $vendor_details){
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
        $vendor->email = $validated['email'];
        $vendor->firstname = $validated['firstname'];
        $vendor->lastname = $validated['lastname'];

        if($request->password)
        $vendor->password = Hash::make($request->password);

        $vendor->role = 'vendor';
        $vendor->save();
        
        if(VendorDetails::where('user_id', $vendor->id)->exists())
            $vendor_details = VendorDetails::where('user_id', $vendor->id)->first();
        else 
            $vendor_details = new VendorDetails;

        $vendor_details->user_id = $vendor->id;
        $vendor_details->vendor_name = $validated['shop_name'];
        $vendor_details->vat = $validated['vat'];
        $vendor_details->address = $request->address;
        $vendor_details->region = $request->region;
        $vendor_details->city = $request->city;
        $vendor_details->phone = $request->phone;
        $vendor_details->contact_person_name = $request->contactperson;
        $vendor_details->contact_person_number = $validated['contactpersonnumber'];
        $vendor_details->subscription = $request->subscription;
        $vendor_details->save();

        if($vendor && $vendor_details){

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
        $vendor = User::with('vendor_details')->find($request->id);
        return response()->json($vendor);
    }
}
