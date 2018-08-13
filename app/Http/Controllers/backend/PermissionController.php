<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Repository\PermissionRepository;
use App\Helpers\JwtAuth;
use App\Helpers\Shinobipermi;

class PermissionController extends Controller
{

    private $permissionrepo;
    private $jwtAuth;
    private $shinobipermi;
    private $tokendecode;

    public function __construct(PermissionRepository $permissionrepo,JwtAuth $jwtAuth,Shinobipermi $shinobipermi){
        $this->middleware('cors');
        $this->permissionrepo     =$permissionrepo;
        $this->jwtAuth            =$jwtAuth;
        $this->shinobipermi       =$shinobipermi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hash         =$request->header('Auth',null);
        $tokendecode  =$this->jwtAuth->decodeToken($hash);

        $jsonresponse=[
            'status' =>'success',
            'data'=>$this->permissionrepo->all()
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
          'slug' =>'required|string|unique:permissions,slug',
        ]);

        if ($validator->fails()) {
          return response()->json([
              'status' =>'error',
              'errors' => $validator->messages(),
              'message' =>'Debe validar los campos obligatorios'
          ],200);
        }

        $name          =isset($params->name) ? $params->name : null;
        $slug          =isset($params->slug) ? $params->slug : null;
        $description   =isset($params->description) ? $params->description : null;

        $attributes =[
          'name'  =>$name,
          'slug'=>$slug,
          'description'=>$description
        ];
        $return   =$this->permissionrepo->create($attributes);

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
              'errors'=>$return->error
          ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
      $permission         =$this->permissionrepo->find($id);

      $jsonresponse=[
          'status' =>'success',
          'data'=>$permission
      ];
      return response()->json($jsonresponse,200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $json         =$request->input('json',null);
        $params       =json_decode($json);
        $params_array =json_decode($json,true);

        $validator =Validator::make($params_array,[
          'name' =>'required|string',
        ]);

        if ($validator->fails()) {
          return response()->json([
              'errors' => $validator->messages(),
              'message' =>'Debe validar los campos obligatorios'
          ], 400);
        }

        $name          =isset($params->name) ? $params->name : null;
        $description   =isset($params->description) ? $params->description : null;

        $attributes =[
          'name'=>$name,
          'description'=>$description
        ];
        $return   =$this->permissionrepo->update($id,$attributes);

        if($return->response){
          return response()->json([
              'status' =>'success',
              'message' => 'Registro actualizado correctamente!',
              'message2' => 'Click para continuar!'
          ],200);
        }else{
          return response()->json([
              'status' =>'error',
              'message' =>'Hubo una inconsistencias al intentar actualizar los datos'
          ], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $return   =$this->permissionrepo->delete($id);

        if($return->response){
          return response()->json([
              'status' =>'success',
              'message' => 'Registro borrado correctamente!',
              'message2' => 'Click para continuar!'
          ],200);
        }else{
          return response()->json([
              'status' =>'error',
              'message' =>'Hubo una inconsistencias al intentar borrar el registro'
          ], 400);
        }
    }
}
