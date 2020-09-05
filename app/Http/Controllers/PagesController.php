<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Page;
class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pages'] = Page::orderBy('title', 'ASC')->get();
        return view('admin.contents.pages',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contents.pages-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        $validated = $request->validated();

        $page = new Page();
        $page->user_id = auth()->user()->id;
        $page->title = $validated['title'];
        $page->slug = $validated['slug'];
        $page->content = $request->content;
        $page->save();

        if($page){
            return response()->json(array('success' => true, 'msg' => 'New page created!'));
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
    public function update(UpdatePageRequest $request)
    {
        $validated = $request->validated();

        $page = Page::find($request->id);
        $page->title = $validated['title'];
        $page->slug = $validated['slug'];
        $page->content = $request->content;
        $page->save();

        if($page){
            return response()->json(array('success' => true, 'msg' => 'Page updated!'));
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
        $page = Page::where('id', $request->id);
        $page->delete();

        if($page){
            return response()->json(array('success' => true, 'msg' => 'Page has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Page, please try again!'));
        }
    }

    public function getPageDataJSON(Request $request){
        $page = Page::find($request->id);
        return response()->json($page);
    }
}
