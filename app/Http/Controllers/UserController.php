<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    
    public function index() {
    }


    public function show(User $user)
    {
        $user = User::where('id', $user->id)->with(['posts'])->first();
        return $user;
    }

    public function view(string $id)
    {
        //
        $user = User::find($id);
        return $user;
    }

   

    public function update(Request $request, User $user)
    {
        //
         $user->fill($request->all())->save();
    
        return $user;
    }

    public function destroy($id)
    {
        //
    }
}
