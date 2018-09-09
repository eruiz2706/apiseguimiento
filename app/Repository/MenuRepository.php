<?php
namespace App\Repository;

use App\Models\Menu;
use DB;

class MenuRepository extends Repository{

  public function __construct(Menu $model){
     parent::__construct($model);
  }

  public function menus(){
      return $this->model->menus();
  }

  public function allparent($attributes=['*'],$orderBy=[['column'=>'id','direction'=>'desc']]){

    $menu=DB::select("select m.*
                        from menus m
                        where m.parent=0
                        order by m.orden asc");

    return $menu;
  }

  public function create($attributes=[],$optional=[]){
      $return =(Object)[
          'response' => false,
      ];
      try{
          $maxorden  =DB::select("select max(orden)+1 as orden
                           from menus
                           where parent=0");
          $attributes['orden']=$maxorden[0]->orden;

          $return->response=true;
          $return->success=$this->model->create($attributes);
      }
      catch(\Exception $e){
          Log::info('create : '.$e->getMessage());
          $return->response=false;
          $return->error=$e->getMessage();
      }

      return $return;
  }


}
