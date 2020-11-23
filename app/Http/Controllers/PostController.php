<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        
        $posts = Post::latest()->orderBy('id', 'DESC')->paginate(8);
        foreach ($posts as $post) {
            $post->setAttribute('user', $post->user->name);
            $post->setAttribute('category', Category::find($post->category_id)->name);
            $post->setAttribute('added', Carbon::parse($post->created_at)->diffForHumans());
            $post->setAttribute('path', '/post/' . $post->slug);
        }
        return response()->json($posts);
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
        //
        $image = $request->image;
        $imageInfo = explode(";base64,", $image);
        $imgExt = str_replace('data:image/', '', $imageInfo[0]);
        $image = str_replace(' ', '+', $imageInfo[1]);
        if($imgExt == 'svg+xml'){
            $imgExt = 'svg';
        }
        $imageName = time() . "." . $imgExt;
        Storage::disk('public')->put($imageName, base64_decode($image));

        Post::create([
            'title' => $request->title,
            'slug' => str::slug($request->title),
            'body' => $request->body,
            'photo' => url('/') . '/storage/' . $imageName,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);
        return response()->json(['message' => 'Article Add successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'photo' => $post->photo,
            'body' => $post->body,
            'slug' => $post->slug,
            'created_at' => $post->created_at->diffForHumans(),
            'user' => $post->user->name,
            'category' => $post->category->name,
            'category_id' => $post->category_id,
            'comments_count' => $post->comments->count(),
            'comments' => $this->commentsArray($post->comments)
        ]);
    }

    public function commentsArray($comments)
    {
        $jsonComments = [];
        foreach ($comments as $comment) {
            array_push($jsonComments, [
                'id' => $comment->id,
                'body' => $comment->body,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => $comment->user->name,
            ]);
        }
        return $jsonComments;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        
        // dd($request->all());
        if($request->image == "undefined"){
            $image = $post->photo;
        }else{
            $images = $request->image;
            $imageInfo = explode(";base64,", $images);
            $imgExt = str_replace('data:image/', '', $imageInfo[0]);
            $image = str_replace(' ', '+', $imageInfo[1]);
            if($imgExt == 'svg+xml'){
                $imgExt = 'svg';
            }
            $image1 = time() . "." . $imgExt;
            Storage::disk('public')->put($image1, base64_decode($image));
            $image = url('/') . '/storage/' . $image1;
        }
        $data = [
            'title' => $request->title,
            'photo' => $image,
            'body' => $request->body,
            'user_id' => $request->user_id,
        ];
        Post::where('id',$post->id)->update($data);

        return response()->json(['message' => 'Article updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return response()->json(['message' => 'Article deleted successfully']);

    }

    public function category($slug)
    {
        $categorie = Category::where('slug', $slug)->first();
        $posts = Post::where('category_id', $categorie->id)->get();
        foreach ($posts as $post) {
            $post->setAttribute('user', $post->user);
            $post->setAttribute('added', Carbon::parse($post->created_at)->diffForHumans());
            $post->setAttribute('path', '/post/' . $post->slug);
        }
        return response()->json($posts);
    }
}
