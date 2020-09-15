<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\PostTag;
use App\Tag;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['posts'] = Post::with(['author','tags'])->orderBy('created_at', 'DESC')->get();
        $data['tags'] = Tag::all();
        #return response()->json($data);
        return view('admin.contents.posts', $data);
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
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->content = $request->content;

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('title')).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/posts', $name.".".$extension);
                $url = Storage::url('posts/'.$name.".".$extension);

                $post->thumbnail = $url;
            }
        }

        $post->save();

        if($request->tags){
            $tags = explode(',', $request->tags);

            foreach($tags as $tag){
                $newPostTag = new PostTag;
                $newPostTag->post_id = $post->id;
                $newPostTag->tag = $tag;
                $newPostTag->save();
            }
        }

        if($post){
            return response()->json(array('success' => true, 'msg' => 'New post created!'));
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
    public function update(UpdatePostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::find($request->id);
        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->content = $request->content;

        if($request->hasFile('image')){
            if($request->file('image')->isValid()){
                // Get image file
                $image = $request->file('image');

                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('title')).'_'.time();

                $extension = $request->image->extension();

                $request->image->storeAs('/public/posts', $name.".".$extension);
                $url = Storage::url('posts/'.$name.".".$extension);

                $post->thumbnail = $url;
            }
        }

        $post->save();

        if($request->tags){
            $tags = explode(',', $request->tags);

            foreach($tags as $tag){
                if(!PostTag::where('tag', $tag)->exists()){
                    $postTag = new PostTag;
                    $postTag->post_tag = $post->id;
                    $postTag->tag = $tag;
                    $postTag->save();
                }
                
            }

            $shouldDeleteTag = PostTag::where('post_id', $post->id)->whereNotIn('tag', $tags);
            $shouldDeleteTag->delete();
        }

        if($post){
            return response()->json(array('success' => true, 'msg' => 'Post updated!'));
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
        $post = Post::where('id', $request->id);
        $post->delete();

        if($post){
            return response()->json(array('success' => true, 'msg' => 'Post has been deleted!'));
        }else{
            return response()->json(array('success' => false, 'msg' => 'We cant delete this Page, please try again!'));
        }
    }

    public function getPostDataJSON(Request $request){
        $post = Post::with('tags')->where('id',$request->id)->first();
        return response()->json($post);
    }
}
