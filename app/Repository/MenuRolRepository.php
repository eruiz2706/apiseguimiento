<?php
namespace App\Repository;

use App\Models\MenuRol;
use DB;

class MenuRolRepository extends Repository{

  public function __construct(MenuRol $model){
     parent::__construct($model);
  }

  /*metodo que muestra solo el menu habilitado para mi rol*/
  public function menus($rolid){
    $modulos=DB::select("select m.id,m.name,m.url,m.icono
                        from menu_rol mr
                        left join menus m on(m.id=mr.menu_id)
                        where enabled=true and m.parent=0 and mr.role_id = :idrol"
                       ,['idrol'=>$rolid]);

    $modulosAll = [];
    foreach($modulos as $mod){
      $submenu=DB::select("select m.id,m.name,m.url,m.icono
                          from menu_rol mr
                          left join menus m on(m.id=mr.menu_id)
                          where enabled=true and m.parent=:parent and mr.role_id = :idrol"
                         ,['idrol'=>$rolid,'parent'=>$mod->id]);
      $mod->submenu=$submenu;
      $modulosAll[]=$mod;
    }

    return $modulosAll;
  }

  /*devuelve el menu y submenu por rol, marcando en true los que tiene habilitados*/
  public function menuaccess($rolid){


    $modulos=DB::select("select m.id,m.name,
                            case when mr.menu_id is not null then true else false end as permi
                            from menus m
                            left join menu_rol mr on(m.id=mr.menu_id and role_id=:idrol)
                            where parent=0
                            order by m.orden asc"
                       ,['idrol'=>$rolid]);

    $modulosAll = [];
    foreach($modulos as $mod){
      $submenu=DB::select("select m.id,m.name,
                              case when mr.menu_id is not null then true else false end as permi
                              from menus m
                              left join menu_rol mr on(m.id=mr.menu_id and role_id=:idrol)
                              where parent=:parent
                              order by m.orden asc"
                         ,['idrol'=>$rolid,'parent'=>$mod->id]);
      $mod->submenu=$submenu;
      $modulosAll[]=$mod;
    }

    return $modulosAll;
  }

}
