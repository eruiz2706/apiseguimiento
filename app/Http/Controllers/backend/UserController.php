<?php

namespace App\Http\Controllers\backend;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Helpers\JwtAuth;

class UserController extends Controller
{

   public function __construct(){
   }

    public function login(Request $request){
        $json   =$request->input('json',null);
        $params =json_decode($json);

        $email    =isset($params->email) ? $params->email : null;
        $password =isset($params->password) ? $params->password : null;

        $validator =Validator::make([
          'email' =>$email,
          'password'=>$password
        ],[
          'email' =>'required|email',
          'password' =>'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
              'status' =>'error',
              'errors' => $validator->messages(),
              'message' =>'Debe validar el usuario y contraseña'
          ],200);
        }

        /*si pasa las validaciones se verifica los datos del usuario*/
        $jwtAuth  =new JwtAuth();
        $pwd      =hash('sha256',$password);

        $signup =$jwtAuth->signup($email,$pwd);

        return response()->json($signup,200);
    }

    public function register(Request $request){
      $json   =$request->input('json',null);
      $params =json_decode($json);

      $email  =(!is_null($json) && isset($params->email)) ? $params->email : null;

      $data=[
        'hol'=>$email
      ];

      return response()->json($data,200);
    }
}
