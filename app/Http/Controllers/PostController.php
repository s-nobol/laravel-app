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
use Intervention\Image\Facades\Image;

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
        if (! $post) {
            return abort(404);
        }
        return $post;
    }

    public function create() {
        //
    }


    // $extension = $request->image->extension();
    public function store(PostRequest $request)
    {
        // 投稿写真の拡張子を取得する
        $image = $request->image;
        $post = new Post();
        
        

        // トランザクションを利用する
        DB::beginTransaction();
        try {
            //記事の作成
            $post->image = 'image.jpg';
            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->description = $request->description;
            $post = Auth::user()->posts()->save($post);
        
            // 画像ファイルの保存
            Storage::cloud()->putFileAs('/posts/'.$post->id, $image, $post->image , 'public');

            // サムネイルの保存
            $thum = Image::make($image);
            $thum->resize(300, null, function($constraint){
                $constraint->aspectRatio();
            });//リサイズ
            $thum->crop(200, 200);
            // $image->save('thum.jpg',75);
            
            $thum =$thum->encode('jpg');
            
            
            // Storage::cloud()->put('/posts/'.$post->id.'/thum.jpg', (string)$thum);
            Storage::disk('s3')->put('/posts/'.$post->id.'/thum.jpg', (string)$thum, 'public');
            
            
            DB::commit();
            
            } catch (\Exception $exception) {
            DB::rollBack();
            // s3のディレクトリごと削除
            Storage::cloud()->deleteDirectory('/posts/'.$post->id);
            throw $exception;
        }
        

        return response($post, 201);
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
