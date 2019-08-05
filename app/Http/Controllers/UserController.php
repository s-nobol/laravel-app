<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Like;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserEdit2Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('auth')->except(['index','show']);// show store edit update delete(ログインユーザーのみ) 
        // $this->authorizeResource(User::class, 'user');   // edit update delete(作成ユーザーのみ) 
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
    
    
    public function update(UserEditRequest $request, User $user)
    {
        $user->fill($request->all())->save();
        return $user;
    }
    
    
    public function update2(UserEdit2Request $request, User $user)
    {
        // 自作ポリシー
        if(Auth::user()->id != $user->id){
            // return $user;
            return abort(403);
        }
        
        $user->fill($request->all())->save();
        $user = User::find($user->id);
        return $user;
    }
    
    
    public function testup(UserEdit2Request $request){
    // public function testup( User $user){
        return "成功";
    }

    public function destroy($id)
    {
        //
    }
}
