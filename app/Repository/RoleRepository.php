<?php
namespace App\Repository;

use Caffeinated\Shinobi\Models\Role;

class RoleRepository extends Repository{

  public function __construct(Role $model){
     parent::__construct($model);
  }

}
