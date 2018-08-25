<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
  protected $table = 'menu_rol';
  protected $fillable =['menu_id','role_id'];
}
