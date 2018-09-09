<?php

namespace App\Http\Controllers\backend;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Helpers\JwtAuth;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;

class UserController extends Controller
{
  private $userrepo;
  private $rolrepo;

   public function __construct(UserRepository $userrepo,RoleRepository $rolrepo,JwtAuth $jwtAuth){
     $this->userrepo     =$userrepo;
     $this->jwtAuth      =$jwtAuth;
     $this->rolrepo      =$rolrepo;
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

    public function index(Request $request){
      $hash         =$request->header('Auth',null);
      $tokendecode  =$this->jwtAuth->decodeToken($hash);

      $jsonresponse=[
          'status' =>'success',
          'data'=>$this->userrepo->allwithrol()
      ];
      return response()->json($jsonresponse,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $selectroles  =$this->rolrepo->all();
      $jsonresponse=[
          'status' =>'success',
          'selectroles'=>$selectroles
      ];
      return response()->json($jsonresponse,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json         =$request->input('json',null);
        $params       =json_decode($json);
        $params_array =json_decode($json,true);

        $validator =Validator::make($params_array,[
          'name' =>'required|string',
          'email' =>'required|string|unique:users,email',
          'rol' =>'required',
          'password'=>'required|string',
          'repassword'=>'required|string',
        ]);

        if ($validator->fails()) {
          return response()->json([
              'status' =>'error',
              'errors' => $validator->messages(),
              'message' =>'Debe validar los campos obligatorios'
          ],200);
        }

        if($params->password != $params->repassword){
          return response()->json([
              'status' =>'error',
              'errors' => ['password'=>['La contraseña y la confirmacion deben ser iguales']],
              'message' =>'Debe validar los campos obligatorios'
          ], 400);
        }

        $name          =isset($params->name) ? $params->name : null;
        $email         =isset($params->email) ? $params->email : null;
        $rol           =isset($params->rol) ? $params->rol : null;
        $password      =isset($params->password) ? $params->password : null;
        $repassword    =isset($params->repassword) ? $params->repassword : null;

        $jwtAuth       =new JwtAuth();
        $pwd           =hash('sha256',$password);

        $attributes =[
          'name'  =>$name,
          'email'=>$email,
          'password'=>$pwd
        ];
        $params=[
          'rol'=>$rol
        ];
        $return   =$this->userrepo->create($attributes,$params);

        if($return->response){
          return response()->json([
              'status' =>'success',
              'message' => 'Registro creado correctamente!',
              'message2' => 'Click para continuar!'
          ],200);
        }else{
          return response()->json([
              'status' =>'error',
              'message' =>'Hubo una inconsistencias al intentar guardar los datos',
              'error'=>$return->error
          ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
      $user         =$this->userrepo->find($id);
      $selectroles  =$this->rolrepo->all();

      $jsonresponse=[
          'status' =>'success',
          'data'=>$user,
          'selectroles'=>$selectroles
      ];
      return response()->json($jsonresponse,200);

    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $json         =$request->input('json',null);
        $params       =json_decode($json);
        $params_array =json_decode($json,true);

        $validator =Validator::make($params_array,[
          'name' =>'required|string',
          'rol' =>'required'
        ]);

        if ($validator->fails()) {
          return response()->json([
              'status' =>'error',
              'errors' => $validator->messages(),
              'message' =>'Debe validar los campos obligatorios'
          ],200);
        }

        $name          =isset($params->name) ? $params->name : null;
        $rol           =isset($params->rol) ? $params->rol : null;
        $password      =isset($params->password) ? $params->password : null;
        $repassword    =isset($params->repassword) ? $params->repassword : null;


        $attributes =[
          'name'  =>$name
        ];
        $optional=[
          'rol'=>$rol
        ];

        if(isset($params->password)){
          if($password != $repassword){
            return response()->json([
                'status' =>'error',
                'errors' => ['password'=>['La contraseña y la confirmacion deben ser iguales']],
                'message' =>'Debe validar los campos obligatorios'
            ], 400);
          }

          $jwtAuth  =new JwtAuth();
          $pwd      =hash('sha256',$password);
          $attributes['password']=$pwd;
        }

        $return   =$this->userrepo->update($id,$attributes,$optional);

        if($return->response){
          return response()->json([
              'status' =>'success',
              'message' => 'Registro actualizado correctamente!',
              'message2' => 'Click para continuar!'
          ],200);
        }else{
          return response()->json([
              'status' =>'error',
              'message' =>'Hubo una inconsistencias al intentar guardar los datos',
              'error'=>$return->error
          ], 400);
        }
    }
}
