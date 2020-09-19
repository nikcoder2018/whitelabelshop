<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Http\Requests\StoreSpecialOfferRequest;
use App\SpecialOffer;
use Carbon\Carbon;
class SpecialOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['special_offers'] = SpecialOffer::with('user')->get();

        return view('admin.contents.special-offers', $data);
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
    public function store(StoreSpecialOfferRequest $request)
    {
        $validated = $request->validated();

        $offer = new SpecialOffer();
        $offer->user_id = auth()->user()->id;
        $offer->title = $validated['title'];
        $offer->description = $validated['description'];
        $offer->time_start = Carbon::create($request->date_start, $request->time_start);
        $offer->time_end = Carbon::create($request->date_end, $request->time_end);
        $offer->price = $validated['price'];
        $offer->status = 'active';

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('title')).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/specialoffers', $name.".".$extension);
                $url = Storage::url('specialoffers/'.$name.".".$extension);

                $offer->image = $url;
            }
        }

        $offer->save();

        return response()->json(array('success'=> true, 'msg' => 'Offer successfully saved.'));
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
    public function update(UpdateSpecialRequest $request)
    {
        $validated = $request->validated();

        $offer = SpecialOffer::find($request->id);
        $offer->title = $validated['title'];
        $offer->description = $validated['description'];
        $offer->time_start = $request->time_start;
        $offer->time_end = $request->time_end;
        $offer->price = $validated['price'];
        $offer->status = 'active';

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('title')).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/specialoffers', $name.".".$extension);
                $url = Storage::url('specialoffers/'.$name.".".$extension);

                $offer->image = $url;
            }
        }

        $offer->save();

        return response()->json(array('success'=> true, 'msg' => 'Offer successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $offer = SpecialOffer::where('id', $request->id);
        $offer->delete();

        if($offer){
            return response()->json(array('success' => true, 'msg' => 'Offer has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Offer, please try again!'));
        }
    }
}
