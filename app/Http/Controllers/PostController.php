<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('auth')->except(['index','show']);
        // $this->authorizeResource(Post::class, 'post');   
    }

    public function index()
    {
        
        return Post::with(['user','likes'])->get();
        // return Post::all();
    }
    
    public function show(Post $post)
    {
        return $post->with(['user','likes'])->first();
        // return $post;
    }


    public function create() {
        //
    }


    public function store(PostRequest $request)
    {
        // 投稿写真の拡張子を取得する
        // $extension = $request->post->extension();
        // ここにnew Post();
        // $post->filename = $post->id . '.' . $extension;
        // Storage::cloud()->putFileAs('', $request->post, $post->filename, 'public');

        // トランザクションを利用する
        // DB::beginTransaction();
        // try {
        //     Auth::user()->posts()->save($post);
        //     DB::commit();} catch (\Exception $exception) {
        //     DB::rollBack();
        //     // DBとの不整合を避けるためアップロードしたファイルを削除
        //     Storage::cloud()->delete($post->filename);
        //     throw $exception;
        // }
        
        //記事の作成
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        return Auth::user()->posts()->save($post);


        // return response($post, 201);
    }

    


    public function edit(Post $post) {
        //
    }


    public function update(PostRequest $request, Post $post)
    {
        //
        // $post
        $post->fill($request->all())->save();;
        
        return $post;
    }


    public function destroy(Post $post)
    {
        //
    }
}
