<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Illuminate\Http\File;
use App\User;
use App\Post;
use App\Like;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserEdit2Request;
use App\Http\Requests\UserImageRequest;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);// show store edit update delete(ログインユーザーのみ) 
        $this->authorizeResource(User::class, 'user');   // edit update delete(作成ユーザーのみ) 
    }
    
    public function index() {
    }


    public function show(User $user)
    {
        $users = User::where('id', $user->id)->first();
        return $users;
    }

    public function view(string $id)
    {
        //
        $user = User::find($id);
        return $user;
    }
    
    
    // ユーザーの記事取得
    public function user_posts(User $user)
    {        
        // $posts = $user->with(['posts'])
        $posts = $user->posts()
            ->orderBy('id', 'desc')
            ->paginate();
        return $posts;
    } 
    
    // ユーザーがいいねした記事取得
    public function user_like_posts(User $user)
    {        
        $likes = $user->likes()
            ->orderBy('id', 'desc')
            ->paginate();
        return $likes;
    }
    
    
   public function edit(User $user)
    {
        return $user;
    }
    
    // ユーザープロフィールの編集（user-show）
    public function update(UserEditRequest $request, User $user)
    {
        $user->fill($request->all())->save();
        return $user;
    }
    
    
    // ユーザープロフィールの編集（user-edit）
    public function update2(UserEdit2Request $request, User $user)
    {
        
        if(Auth::user()->id != $user->id){
            // return $user;
            return abort(403);
        }
        $user->fill($request->all())->save();
        $user = User::find($user->id);
        return $user;
    }
    
    // ユーザープロフィール画像の編集（user-edit）
    public function image_upload(UserImageRequest $request, User $user){
        // 自作ポリシー
        if(Auth::user()->id != $user->id){
            return abort(403);
        }
        
        
        $user->image = "image.jpg";
        $user->save();
        
        
        // 画像のサイズ取得
        $image = Image::make($request->image);
        $image->resize(200, null, function($constraint){
            $constraint->aspectRatio();
        });//リサイズ
        $image->crop(200, 200);
        // $image->save('thum.jpg',75);
        
        $image =  $image->encode('jpg');
        // $image->save($file_path); //特定のファイルに保存
        
        
        Storage::disk('s3')->put('/users/'.$user->id.'/image.jpg', (string)$image, 'public');
        // Storage::cloud()->put('/users/'.$user->id.'/image.jpg', $image->response());
        
        return $request;
    }
    
    

    public function destroy($id)
    {
        //
    }
    
    
// 画像を横幅300px・縦幅アスペクト比維持の自動サイズへリサイズ
// $image = \Image::make($request->image)
//     ->resize(100, null, function ($constraint) {
//         $constraint->aspectRatio();
// })->save();"Call to a member function getRealPath() on string"

// $data = (string) Image::make($request->image)->encode('jpg', 30);
}
