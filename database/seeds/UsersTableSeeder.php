<?php

use Illuminate\Database\Seeder;
use App\User;
use Caffeinated\Shinobi\Models\Role;
use App\Models\RoleUser;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*creacion de los usuarios*/
        $user1  =User::create([
          'name' =>'Administrados',
          'email'=>'administrador@seguimiento.com',
          'password'=>hash('sha256','123')
        ]);

        $user2  =User::create([
          'name' =>'Sin Permisos de nada',
          'email'=>'no_access@seguimiento.com',
          'password'=>hash('sha256','123')
        ]);

        $user3  =User::create([
          'name' =>'Administrados',
          'email'=>'limitado@seguimiento.com',
          'password'=>hash('sha256','123')
        ]);

        /*asignacion de los permisos*/
        $role1 =Role::where('slug','admin')->first();
        RoleUser::create([
          'role_id' =>$role1->id,
          'user_id' =>$user1->id
        ]);

        $role2 =Role::where('slug','no_access')->first();
        RoleUser::create([
          'role_id' =>$role2->id,
          'user_id' =>$user2->id
        ]);

        $role3 =Role::where('slug','acceso_limitado')->first();
        RoleUser::create([
          'role_id' =>$role3->id,
          'user_id' =>$user3->id
        ]);
    }
}
