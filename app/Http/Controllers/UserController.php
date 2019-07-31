<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Like;
use App\Http\Requests\UserEditRequest;

class UserController extends Controller
{
    
    public function index() {
    }


    public function show(User $user)
    {
        $users = User::where('id', $user->id)->with(['posts'])->first();
        // $user = User::where('id', $user->id);
    // $photo = Photo::where('id', $id)->with(['owner'])->first();
        // return $user->with(['posts'])->get();
        return $users;
    }

    public function view(string $id)
    {
        //
        $user = User::find($id);
        return $user;
    }
    
    
    public function user_likes(User $user)
    {        
        $likes = $user->likes;
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
