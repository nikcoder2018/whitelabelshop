<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Vendor;
use App\VendorProfile;
use App\LocationRegion;
use App\LocationCountry;
use App\LocationCity;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['vendors'] = Vendor::with('vendor_details')->get();

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

        $vendor = new Vendor();
        $vendor->vendor_name = $validated['shop_name'];
        $vendor->email = $validated['email'];
        $vendor->password = Hash::make($validated['password']);
        $vendor->vat = $validated['vat'];
        $vendor->city = $validated['city'];
        $vendor->country = $validated['country'];
        $vendor->save();

        $vendor_details = new VendorProfile();
        $vendor_details->vendor_id = $vendor->id;
        $vendor_details->firstname = $validated['firstname'];
        $vendor_details->lastname = $validated['lastname'];
        $vendor_details->phone = $request->phone;
        $vendor_details->address = $request->address;
        $vendor_details->contact_person_name = $request->contactperson;
        $vendor_details->contact_person_number = $request->contactpersonnumber;
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

        $vendor = Vendor::find($request->id);
        $vendor->email = $validated['email'];
        $vendor->vendor_name = $validated['shop_name'];
        $vendor->country = $request->country;
        $vendor->city = $request->city;
        $vendor->vat = $validated['vat'];
        
        if($request->password)
        $vendor->password = Hash::make($request->password);
        $vendor->save();
        
        if(VendorProfile::where('vendor_id', $vendor->id)->exists())
            $vendor_details = VendorProfile::where('vendor_id', $vendor->id)->first();
        else 
            $vendor_details = new VendorProfile;

        $vendor_details->vendor_id = $vendor->id;
        $vendor_details->firstname = $validated['firstname'];
        $vendor_details->lastname = $validated['lastname'];
        $vendor_details->address = $request->address;
        $vendor_details->phone = $request->phone;
        $vendor_details->contact_person_name = $request->contactperson;
        $vendor_details->contact_person_number = $request->contactpersonnumber;
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
        $vendor = Vendor::where('id', $request->id);
        $vendor->delete();

        if($vendor){
            return response()->json(array('success' => true, 'msg' => 'Vendor has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Vendor, please try again!'));
        }
    }

    public function getVendorDataJSON(Request $request){
        $vendor = Vendor::with('vendor_details')->find($request->id);
        return response()->json($vendor);
    }
}
