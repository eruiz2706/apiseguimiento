<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function register(Request $request){
      $json   =$request->input('json',null);
      $params =json_decode($json);

      $email  =(!is_null($json) && isset($params->email)) ? $params->email : null;

      $data=[
        'hol'=>$email
      ];

      return response()->json($data,200);
    }

    public function prueba(Request $request){


    }
}
