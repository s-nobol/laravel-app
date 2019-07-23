<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    
    
    public function __construct()
    {
        $this->middleware('auth')->except(['view']);
        // $this->authorizeResource(Comment::class, 'comment');   
    }


    // コメント一覧
    public function view(string $id)
    {   
        $comment = Comment::where('post_id', $id)->with(['user'])->get();
        return $comment;
    }


    public function store(Request $request, Post $post)
    {   
        Auth::user()->comments()->create($request->all());
        return $request;
    }



    public function destroy(Comment $comment)
    {
        //$comment->delete();
        return "コメント削除しました";
    }
}



// コメント作成メゾット(予備)
// $comment = new Comment();
// $comment->content = $request->content;
// $comment->user_id = Auth::user()->id;
// $post->comments()->save($comment);
// return $request->all();