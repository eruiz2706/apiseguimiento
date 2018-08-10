<?php
namespace App\Repository;

use App\Models\Menu;

class MenuRepository extends Repository{

  public function __construct(Menu $model){
     parent::__construct($model);
  }

}
