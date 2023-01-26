<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    //
    function index (){
        return view('admin.sizes.index')->with('sizes',Size::paginate(5));
    
    }
    function create (){
        return view('admin.sizes.create');
    
    }
    function store (Request $request){
        $request->validate(size::$rules);

        DB::table('sizes')->insert(array('name' => $request['name']));

        return redirect()->route('sizes.index');
    }
    function edit ($id){
        $size = size::findOrFail($id);
        return view('admin.sizes.edit',compact('size'));
    }
    function update($id, Request $request)
    {
        $size = size::findOrFail($id);
        $request->validate(size::$rules);
        DB::table('sizes')->where('id', $id)->update(array( "name"=>$request['name']));
        return redirect()->route('sizes.index');
    }

    function show($id)
    {
        $size = size::findOrFail($id);
        return view('admin.sizes.show', compact('size'));
    }
    function destroy ($id){
        $size = size::findOrFail($id);
        size::destroy($id);
        return redirect()->route('sizes.index')->with('success','Record has been deleted');
    }
}
