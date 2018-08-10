<?php
namespace App\Helpers;

use App\User;
use Caffeinated\Shinobi\Models\Role;


class Shinobipermi{

    public function __construct(){

    }

    public function canrol($idrol,$permission){
        $role =Role::where('id',$idrol)->first();
        return $role->can($permission);
        return true;
    }

}
