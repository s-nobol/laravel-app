<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
    
    public function store(Post $post)
    {
        $post->likes()->detach(Auth::user()->id);
        $post->likes()->attach(Auth::user()->id);
        
        $post = Post::find($post->id);
        return  $post;
        
    }



    public function destroy(Post $post)
    {
        $post->likes()->detach(Auth::user()->id);
        $post = Post::find($post->id);
        return  $post;
    }
}
