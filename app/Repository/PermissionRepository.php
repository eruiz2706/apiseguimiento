<?php
namespace App\Repository;

use App\Models\Permission;

class PermissionRepository extends Repository{

  public function __construct(Permission $model){
     parent::__construct($model);
  }

}
