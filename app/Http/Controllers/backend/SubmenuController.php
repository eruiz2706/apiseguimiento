<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Repository\SubmenuRepository;
use App\Repository\MenuRepository;
use App\Helpers\JwtAuth;
use App\Helpers\Shinobipermi;

class SubmenuController extends Controller
{

    private $submenurepo;
    private $menurepo;
    private $jwtAuth;
    private $shinobipermi;

    public function __construct(SubmenuRepository $submenurepo,MenuRepository $menurepo,JwtAuth $jwtAuth,Shinobipermi $shinobipermi){
          $this->submenurepo  =$submenurepo;
          $this->menurepo    =$menurepo;
          $this->jwtAuth      =$jwtAuth;
          $this->shinobipermi =$shinobipermi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $jsonresponse=[
          'status' =>'success',
          'data'=>$this->submenurepo->allchildren()
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
      $selectmenu  =$this->menurepo->allparent();
      $jsonresponse=[
          'status' =>'success',
          'selectmenu'=>$selectmenu
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
          'menu' =>'required',
          'name' =>'required|string',
          'slug' =>'required|string|unique:menus,slug',
          'url' =>'required',
          'icono'=>'required|string',
        ]);

        if ($validator->fails()) {
          return response()->json([
              'status' =>'error',
              'errors' => $validator->messages(),
              'message' =>'Debe validar los campos obligatorios'
          ],200);
        }

        $menu          =isset($params->menu) ? $params->menu : null;
        $name          =isset($params->name) ? $params->name : null;
        $slug          =isset($params->slug) ? $params->slug : null;
        $url           =isset($params->url) ? $params->url : null;
        $icono         =isset($params->icono) ? $params->icono : null;
        $enabled       =isset($params->enabled) ? $params->enabled : null;

        $attributes =[
          'name'  =>$name,
          'slug'=>$slug,
          'url'=>$url,
          'icono'=>$icono,
          'enabled'=>$enabled,
          'parent'=>$menu
        ];
        $return   =$this->submenurepo->create($attributes);

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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $submenu     =$this->submenurepo->find($id);
      $selectmenu  =$this->menurepo->allparent();

      $jsonresponse=[
          'status' =>'success',
          'data'=>$submenu,
          'selectmenu'=>$selectmenu
      ];
      return response()->json($jsonresponse,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $json         =$request->input('json',null);
      $params       =json_decode($json);
      $params_array =json_decode($json,true);

      $validator =Validator::make($params_array,[
        'menu' =>'required',
        'name' =>'required|string',
        'url' =>'required',
        'icono'=>'required|string',
      ]);

      if ($validator->fails()) {
        return response()->json([
            'status' =>'error',
            'errors' => $validator->messages(),
            'message' =>'Debe validar los campos obligatorios'
        ],200);
      }

      $menu          =isset($params->menu) ? $params->menu : null;
      $name          =isset($params->name) ? $params->name : null;
      $url           =isset($params->url) ? $params->url : null;
      $icono         =isset($params->icono) ? $params->icono : null;
      $enabled       =isset($params->enabled) ? $params->enabled : null;

      $attributes =[
        'name'  =>$name,
        'url'=>$url,
        'icono'=>$icono,
        'enabled'=>$enabled,
        'parent'=>$menu
      ];
      $return   =$this->menurepo->update($id,$attributes);

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
        //
    }
}
