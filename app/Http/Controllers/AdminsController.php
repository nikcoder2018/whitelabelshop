<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\User;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['admins'] = User::where('role', 'admin')->get();

        return view('admin.contents.users-admin',$data);
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
    public function store(StoreAdminRequest $request)
    {
        $validated = $request->validated();

        $admin = new User();
        $admin->email = $validated['email'];
        $admin->firstname = $validated['firstname'];
        $admin->lastname = $validated['lastname'];
        $admin->password = Hash::make($validated['password']);
        $admin->role = 'admin';
        $admin->save();

        if($admin){
            return response()->json(array('success' => true, 'msg' => 'New admin created!'));
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
    public function edit(Request $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request)
    {
        $validated = $request->validated();
        $admin = User::find($request->id);
        $admin->email = $validated['email'];
        $admin->firstname = $validated['firstname'];
        $admin->lastname = $validated['lastname'];

        if($request->password)
        $admin->password = Hash::make($request->password);
        $admin->save();

        if($admin){

            return response()->json(array('success' => true, 'msg' => 'Admin updated!'));
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
        $admin = User::where('id', $request->id);
        $admin->delete();

        if($admin){
            return response()->json(array('success' => true, 'msg' => 'Admin has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Admin, please try again!'));
        }
    }

    public function getAdminDataJSON(Request $request){
        $admin = User::find($request->id);
        return response()->json($admin);
    }
}
