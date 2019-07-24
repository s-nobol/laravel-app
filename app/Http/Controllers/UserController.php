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
        //
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
