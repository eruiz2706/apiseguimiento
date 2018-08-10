<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MenuRepository;
use App\Helpers\JwtAuth;
use App\Helpers\Shinobipermi;

class MenuController extends Controller
{
    private $menurepo;
    private $jwtAuth;
    private $shinobipermi;

    public function __construct(MenuRepository $menurepo,JwtAuth $jwtAuth,Shinobipermi $shinobipermi){
        header('Access-Control-Allow-Origin: *');
        $this->menurepo     =$menurepo;
        $this->jwtAuth      =$jwtAuth;
        $this->shinobipermi =$shinobipermi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hash       =$request->header('Auth',null);
        if(!$this->jwtAuth->checkToken($hash)){
          $jsonresponse=[
              'status' =>'error',
              'message'=>'Autenticacion fallida'
          ];
        }else{


          $jsonresponse=[
              'status' =>'success',
              'data'=>$this->menurepo->all(),
              'das'=>$this->shinobipermi->canrol(1,'users.index')
          ];
        }

        return response()->json($jsonresponse,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
