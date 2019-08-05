<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostEditRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show','view']); //store update delete(ログインユーザーのみ)
        $this->authorizeResource(Post::class, 'post');    // update delete(作成ユユーザーのみ) 
    }

    public function index()
    {
        
        // return Post::with(['user','likes'])->get();
        return Post::take(15)
            ->orderBy('id', 'desc')
            ->paginate();
            
    }
    
    public function show(Post $post)
    {
        $post = Post::where('token', $post)->with(['user','category'])->first();
        return $post;
    }
    
    // post-showの代わり
    public function view(string $token){
        
        $post = Post::where('token', $token)->with(['user','category'])->first();
        return $post;
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
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->description = $request->description;
        return Auth::user()->posts()->save($post);


        // return response($post, 201);
    }

    


    public function edit(Post $post) {
        //
    }


    public function update(PostEditRequest $request, Post $post)
    {
    
        $post->fill($request->all())->save();
        $post = Post::where('token', $post->token)->with(['user','category'])->first();
        return $post;
    }


    public function destroy(Post $post)
    {
        //
        // $post->delete;
        return "記事を削除しました";
    }
}
