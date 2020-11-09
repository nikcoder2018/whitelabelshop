<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('order', 'ASC')->get();
        $data['categories_nestable'] = Category::BuildNestableHTML($categories->toArray());
        $data['categories'] = $categories;

        #return response()->json($data);
        return view('admin.contents.categories', $data);
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
        $category = new Category;
        $category->user_id = Auth()->user()->id;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->name).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/categories', $name.".".$extension);
                $url = Storage::url('categories/'.$name.".".$extension);

                $category->image = $url;
            }
        }
        $category->icon = $request->icon;
        $category->parent = $request->parent;
        $category->save();

        if($category){
            $categories = Category::all();
            $html_build_tree = Category::BuildTreeHTML($categories->toArray());
            return response()->json(array('success' => true, 'msg' => 'Category added successfully.', 'html_build' => $html_build_tree));
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
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->name).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/categories', $name.".".$extension);
                $url = Storage::url('categories/'.$name.".".$extension);

                $category->image = $url;
            }
        }
        $category->icon = $request->icon;
        $category->parent = $request->parent;
        $category->save();

        if($category){
            $categories = Category::all();
            $html_build_tree = Category::BuildTreeHTML($categories->toArray());
            return response()->json(array('success' => true, 'msg' => 'Category updated successfully.', 'html_build' => $html_build_tree));
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
        $category = Category::where('id', $request->id)->where('user_id', auth()->user()->id);
        $category->delete();

        if($category){
            $categories = Category::all();
            $html_build_tree = Category::BuildTreeHTML($categories->toArray());
            return response()->json(array('success' => true, 'msg' => 'Category has been deleted!', 'html_build' => $html_build_tree));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this category, please try again!'));
        }
        
    }

    public function getCategoriesJSON(){
        $categories = Category::all()->toArray();

        $array_categories = Category::BuildTreeHTML($categories);

        return response()->json($array_categories);
    }

    public function getCategoryDataJSON(Request $request){
        $category = Category::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
        return response()->json($category);
    }

    public function sortCategoryAjax(Request $request){
        $this->sortCategory($request->list, null);
    }
    public function sortCategory($categories, $parent){
        foreach($categories as $order=>$category){
            $cat = Category::find($category['id']);
            
            $cat->parent = $parent;
            
            $cat->order = $order;
            $cat->save();

            if(isset($category['children'])){
                $this->sortCategory($category['children'], $category['id']);
            }
        }
    }
}
