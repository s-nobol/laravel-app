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
        $this->middleware('auth')->except(['view','show']);
        // $this->authorizeResource(Comment::class, 'comment');   
    }


    // 記事のコメント一覧
    public function view(string $id)
    {   
        $comment = Comment::where('post_id', $id)
            ->orderBy('id', 'desc')
            ->with(['user'])
            ->paginate();
            
        return $comment;
    } 
    
    // ユーザーの作成したコメント一覧
    public function show(string $id)
    {   
        $comment = Comment::where('post_id', $id);
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
