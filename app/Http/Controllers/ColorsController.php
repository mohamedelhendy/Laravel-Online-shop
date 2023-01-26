<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorsController extends Controller
{
    function index (){
        return view('admin.colors.index')->with('colors',Color::paginate(5));
    
    }
    function create (){
        return view('admin.colors.create');
    
    }
    function store (Request $request){
        $request->validate(color::$rules);

        DB::table('colors')->insert(array('name' => $request['name']));

        return redirect()->route('colors.index');
    }
    function edit ($id){
        $color = color::findOrFail($id);
        return view('admin.colors.edit',compact('color'));
    }
    function update($id, Request $request)
    {
        $color = color::findOrFail($id);
        $request->validate(color::$rules);
        DB::table('colors')->where('id', $id)->update(array( "name"=>$request['name']));
        return redirect()->route('colors.index');
    }

    function show($id)
    {
        $color = color::findOrFail($id);
        return view('admin.colors.show', compact('color'));
    }
    function destroy ($id){
        $color = color::findOrFail($id);
        color::destroy($id);
        return redirect()->route('colors.index')->with('success','Record has been deleted');
    }

}
