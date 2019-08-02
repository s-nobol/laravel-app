<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Like;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
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
    
    

    public function update(Request $request, User $user)
    {
        $user->fill($request->all())->save();
        return $user;
    }
    
    public function update2(UserEditRequest $request, User $user)
    {
        // $user->fill($request->all())->save();
        return $user;
    }

    public function destroy($id)
    {
        //
    }
}
