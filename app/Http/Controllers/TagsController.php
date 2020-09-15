<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Tag;
use Auth;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tags'] = Tag::where('user_id', Auth::user()->id)->get();

        return view('admin.contents.tags', $data);
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
        $tag = new Tag();
        $tag->user_id = Auth::user()->id;
        $tag->tag = $request->tag;
        $tag->slug = $request->slug;
        $tag->description = $request->description;

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->name).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/tags', $name.".".$extension);
                $url = Storage::url('tags/'.$name.".".$extension);

                $tag->image = $url;
            }
        }
        $tag->icon = $request->icon;

        $tag->save();

        if($tag){
            return response()->json(array('success' => true, 'msg' => 'Tag added successfully.', 'details' => $tag));
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
    public function edit(Request $request)
    {
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
        $tag = Tag::find($request->id);
        $tag->tag = $request->tag;
        $tag->slug = $request->slug;
        $tag->description = $request->description;

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->name).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/tags', $name.".".$extension);
                $url = Storage::url('tags/'.$name.".".$extension);

                $tag->image = $url;
            }
        }
        $tag->icon = $request->icon;

        $tag->save();

        if($tag){
            return response()->json(array('success' => true, 'msg' => 'Tag added successfully.', 'details' => $tag));
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
        $tag = Tag::find($request->id);
        $tag->delete();

        if($tag){
            return response()->json(array('success' => true, 'msg' => 'Tag has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Tag, please try again!'));
        }
    }

    public function getTagDataJSON(Request $request){
        $tag = Tag::where('id',$request->id)->first();
        return response()->json($tag);
    }
}
