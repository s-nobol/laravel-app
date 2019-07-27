<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use  App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    
    
    public function __construct()
    {
        // $this->middleware('auth')->except(['view']);
        // $this->authorizeResource(Comment::class, 'comment');   
    }


    // コメント一覧
    public function view(string $id)
    {   
        $comment = Comment::where('post_id', $id)->with(['user'])->get();
        // $comment = Comment::where('post_id', $id)->get();
        return $comment;
    }


    public function store(CommentRequest $request, Post $post)
    {   
        $comment = Auth::user()->comments()->create($request->all());
        return $comment;
    }



    public function destroy(Comment $comment)
    {
        $comment->delete();
        return  $comment;
    }
}



// コメント作成メゾット(予備)
// $comment = new Comment();
// $comment->content = $request->content;
// $comment->user_id = Auth::user()->id;
// $post->comments()->save($comment);
// return $request->all();