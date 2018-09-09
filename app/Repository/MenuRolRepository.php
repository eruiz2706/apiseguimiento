<?php
namespace App\Repository;

use App\Models\MenuRol;
use DB;

class MenuRolRepository extends Repository{

  public function __construct(MenuRol $model){
     parent::__construct($model);
  }

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

}
