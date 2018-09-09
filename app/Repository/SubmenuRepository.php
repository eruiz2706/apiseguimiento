<?php
namespace App\Repository;

use App\Models\Menu;
use DB;

class SubmenuRepository extends Repository{

  public function __construct(Menu $model){
     parent::__construct($model);
  }

  public function allchildren($attributes=['*'],$orderBy=[['column'=>'id','direction'=>'desc']]){

    $submenu=DB::select("select p.name as menu,m.*
                      	from menus m
                      	left join menus p on(m.parent=p.id)
                      	where m.parent<>0
                      	order by p.name,m.orden asc");

    return $submenu;
  }

  public function create($attributes=[],$optional=[]){
      $return =(Object)[
          'response' => false,
      ];
      try{
          $maxorden  =DB::select("select max(orden)+1 as orden
                           from menus
                           where parent= :parent",
                         ['parent'=>$attributes['parent']]);
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

  public function update($id,$attributes=[],$optional=[]){
      $return =(Object)[
          'response' => false,
      ];

      try{
          $maxorden  =DB::select("select max(orden)+1 as orden
                           from menus
                           where parent= :parent",
                         ['parent'=>$attributes['parent']]);
          $attributes['orden']=$maxorden[0]->orden;

          $return->response=true;
          $return->success=$this->model->where('id',$id)->update($attributes);
      }
      catch(\Exception $e){
          Log::info('update : '.$e->getMessage());
          $return->response=false;
          $return->error=$e->getMessage();
      }

      return $return;
  }


}
