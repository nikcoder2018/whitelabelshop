<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Http\Requests\StoreProductRequest;
use App\Product;
use App\ProductTag;
use App\ProductCategory;
use App\Category;
use App\Tag;
use App\User;
use App\Vendor;
use Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['search'] = $request->search;
        $data['products'] = Product::with(['vendor','categories'])->where('title', 'like', $request->search.'%')->get();
        
        #return response()->json($data);exit;
        return view('admin.contents.products',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::all();
        $data['tags'] = Tag::all();
        $data['categoriesHTML'] = Category::BuildTreeHTML2(Category::all()->toArray());
        $data['vendors'] = Vendor::all();

        #return response()->json($data);exit;
        return view('admin.contents.products-add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $newProduct = new Product();
        $newProduct->vendor_id = $request->vendor;
        $newProduct->title = $validated['title'];
        $newProduct->slug = $request->slug;
        $newProduct->description = $request->description;

        $slug = $this->slugify($validated['title']);
        if(!Product::where('slug', $slug)->exists()){
            $newProduct->slug = $slug;
        }else{
            $newProduct->slug = $slug.'_'.time();
        }
   
        $newProduct->regular_price = $validated['regular_price'];

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('title')).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/products', $name.".".$extension);
                $url = Storage::url('products/'.$name.".".$extension);

                $newProduct->image_url = $url;
            }
        }
        
        $newProduct->save();

        if($request->tags){
            $tags = explode(',', $request->tags);

            foreach($tags as $tag){
                $newProductTag = new ProductTag;
                $newProductTag->product_id = $newProduct->id;
                $newProductTag->tag = $tag;
                $newProductTag->save();
            }
        }

        if($request->categories){
            foreach($request->categories as $category){
                $newProductCategory = new ProductCategory;
                $newProductCategory->product_id = $newProduct->id;
                $newProductCategory->category_id = $category;
                $newProductCategory->save();
            }
        }
        return response()->json(array('success'=> true, 'msg' => 'Product successfully saved.'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = Category::where('user_id', Auth::user()->id)->get();
        $data['tags'] = Tag::where('user_id', Auth::user()->id)->get();
        $data['categoriesHTML'] = Category::BuildTreeHTML2(Category::all()->toArray(), 0, ProductCategory::where('product_id', $id)->get());
        $data['product'] = Product::with(['categories', 'tags'])->where('id', $id)->first();
        $data['vendors'] = Vendor::all();

        #return response()->json($data);exit;
        return view('admin.contents.products-edit', $data);
    }

    public function all(Request $request)
    {
        if($request->search != null){
            $data['products'] = Product::where('title', 'like', $request->search.'%')->get();
        }else{
            $data['products'] = Product::all();
        }
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::find($request->id);
        $product->vendor_id = $request->vendor;
        $product->title = $validated['title'];
        $product->slug = $validated['slug'];
        $product->description = $request->description;

        $product->regular_price = $validated['regular_price'];

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('title')).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/products', $name.".".$extension);
                $url = Storage::url('products/'.$name.".".$extension);

                $product->image_url = $url;
            }
        }
        
        $product->save();

        if($request->tags){
            $tags = explode(',', $request->tags);

            foreach($tags as $tag){
                if(!ProductTag::where('tag', $tag)->exists()){
                    $productTag = new ProductTag;
                    $productTag->product_id = $product->id;
                    $productTag->tag = $tag;
                    $productTag->save();
                }
                
            }

            $shouldDeleteTag = ProductTag::where('product_id', $product->id)->whereNotIn('tag', $tags);
            $shouldDeleteTag->delete();
        }

        if($request->categories){
            $newCategoriesIds = array();
            foreach($request->categories as $category){
                
                if(!ProductCategory::where('product_id', $product->id)->where('category_id', $category)->exists()){
                    $newProductCategory = new ProductCategory;
                    $newProductCategory->product_id = $product->id;
                    $newProductCategory->category_id = $category;
                    $newProductCategory->save();
                }
                
                array_push($newCategoriesIds, $category);
            }

            $notSelectedCategories = ProductCategory::where('product_id', $product->id)->whereNotIn('category_id',$newCategoriesIds);
            $notSelectedCategories->delete();
        }
        return response()->json(array('success'=> true, 'msg' => 'Product successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->id);
        $product->delete();

        if($product){
            return response()->json(array('success' => true, 'msg' => 'Product has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Product, please try again!'));
        }
    }

    public function slugify($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
            
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
    
        // trim
        $text = trim($text, '-');
    
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
    
        // lowercase
        $text = strtolower($text);
    
        if (empty($text)) {
            $text = 'n-a';
        }
    
        return $text;
    }
}
