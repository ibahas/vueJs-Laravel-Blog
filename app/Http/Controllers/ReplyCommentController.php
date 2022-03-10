<?php

namespace App\Http\Controllers;

use App\Comment;
use App\replyComment;
use Illuminate\Http\Request;

class ReplyCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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


        $newReply = replyComment::create([
            'comment' => $request->comments,
            'user' => $request->user,
            'reply' => $request->reply,
        ]);


        // replyComment::create($newReply);
        return response()->json([
            'comment' => $newReply->comment,
            'user' => $newReply->user,
            'created_at' => $newReply->created_at->diffForHumans(),
            'reply' => $newReply->reply,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\replyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function show(replyComment $replyComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\replyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function edit(replyComment $replyComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\replyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, replyComment $replyComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\replyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = replyComment::find($id)->delete($id);
        return response()->json(['data' => 'Reply deleted']);
    }
}
