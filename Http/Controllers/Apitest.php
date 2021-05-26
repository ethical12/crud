<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\todos;
class Apitest extends Controller
{
    function list(){
      return todos::all();
    }

    function create(Request $request){
      $userdata = new Todos();
      $userdata->name=$request->input('name');
        $userdata->number=$request->input('mobile');
        $userdata->email=$request->input('email');
        $userdata->role=$request->input('role');
        $userdata->status=$request->input('status');
        $userdata->created_at=$request->input('c_at');
        $userdata->updated_at=$request->input('u_at');
        $userdata->save();
        return response()->json($userdata);
    }
}
