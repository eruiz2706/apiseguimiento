<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MenuRolRepository;
use App\Helpers\JwtAuth;
use App\Helpers\Shinobipermi;

class MenuRolController extends Controller
{

    private $menurolrepo;
    private $jwtAuth;
    private $shinobipermi;

    public function __construct(MenuRolRepository $menurolrepo,JwtAuth $jwtAuth,Shinobipermi $shinobipermi){
        $this->menurolrepo  =$menurolrepo;
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
      $hash         =$request->header('Authorization',null);
      $tokendecode  =$this->jwtAuth->decodeToken($hash);

      $jsonresponse=[
          'status' =>'success',
          'data'=>$this->menurolrepo->menus($tokendecode->roleid)
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function access(Request $request,$id)
    {
      $jsonresponse=[
          'status' =>'success',
          'data'=>$this->menurolrepo->menuaccess($id)
      ];

      return response()->json($jsonresponse,200);
    }
}
