<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class adminController extends Controller
{
    function admin (){
        return view('admin.admin');
    }
    function users (){
        return view('admin.users')->with('users', User::paginate(5));
    
    }
    function setAdmin (Request $request){
        $id = $request['id'];
        $user =User::findOrFail($id);
        $user['is_admin'] = 1;
        $user->save();
        return redirect()->route('users');
    
    }
    function deleteUser (Request $request){
        $id = $request['id'];
        User::destroy($id);

        return redirect()->route('users');
    
    }
    
}
