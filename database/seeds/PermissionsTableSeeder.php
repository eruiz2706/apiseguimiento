<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
          'name' =>'Listar usuarios',
          'slug' =>'users.index',
          'description' =>'Lista todos los usuarios del sistema'
        ]);
        Permission::create([
          'name' =>'Ver detalle de usuario',
          'slug' =>'users.show',
          'description' =>'Ver en detalle cada usuario del sistema'
        ]);
        Permission::create([
          'name' =>'Edicion de usuarios',
          'slug' =>'users.edit',
          'description' =>'Editar cualquier dato de un usuario del sistema'
        ]);
        Permission::create([
          'name' =>'Eliminar usuario',
          'slug' =>'users.destroy',
          'description' =>'Eliminar cualquier usuario del sistema'
        ]);
    }
}
