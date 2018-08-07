<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Helpers\JwtAuth;

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

    public function login(Request $request){
        $jwtAuth  =new JwtAuth();

        $json   =$request->input('json',null);
        $params =json_decode($json);

        $email    =(!is_null($json) && isset($params->email)) ? $params->email : null;
        $password =(!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken =(!is_null($json) && isset($params->gettoken)) ? $params->gettoken : null;


        //$pwd  =Hash::make($password);
        $pwd  =hash('sha256',$password);

        if(!is_null($email) && !is_null($password)){

          $signup =$jwtAuth->signup($email,$pwd,$getToken);

          return response()->json($signup,200);
        }else{
           return response()->json([
             'status' =>'error',
             'message' => 'Datos invalidos'
           ],200);
        }
    }
}
