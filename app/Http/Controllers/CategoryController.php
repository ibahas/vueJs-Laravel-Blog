<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select(DB::raw('count(posts.category_id) as count, category_id'))
            ->groupBy('posts.category_id')->take(5)
            ->orderBy('count', 'DESC')
            ->get();


        for ($i = 0; $i <= 4; $i++) {
            # code...
            $data->put($i, ['count' => $data[$i]->count, 'slug' => Category::find($data[$i]->category_id)->slug, 'name' => Category::find($data[$i]->category_id)->name]);
        }
        return response()->json(['categories' => $data]);
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
        // dd($request->all());
        $validator = validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->messages()]);
        }
        $category = Category::create([
            'name' => $request->name,
            'slug' => str::slug($request->name),
        ]);
        return response()->json(['data' => 'Successfuly']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Category::where('slug', $id)->first();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
    /**
     * Get All Categories
     */
    public function getAll()
    {
        # code...
        return response()->json(['categories' => Category::all()]);
    }

    public function getCategory($id)
    {
        # code...
        return response()->json(['data' => Category::find($id)]);
    }
}
