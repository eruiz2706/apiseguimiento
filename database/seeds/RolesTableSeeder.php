<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Role::create([
        'name' =>'Administrador del sistema',
        'slug'=>'admin',
        'special'=>'all-access'
      ]);

      Role::create([
        'name' =>'Acceso Restringido',
        'slug' =>'no_access',
        'special' =>'no-access'
      ]);

      Role::create([
        'name' =>'Acceso limitado',
        'slug' =>'acceso_limitado',
      ]);
    }
}
