<?php

use Illuminate\Database\Seeder;
use App\User;
use Caffeinated\Shinobi\Models\Role;
use App\Models\RoleUser;
use App\Models\Menu;
use App\Models\MenuRol;

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
          'name' =>'Administrador',
          'email'=>'administrador@seguimiento.com',
          'password'=>hash('sha256','123')
        ]);

        $user2  =User::create([
          'name' =>'Vendedor',
          'email'=>'vendedor@seguimiento.com',
          'password'=>hash('sha256','123')
        ]);

        $user3  =User::create([
          'name' =>'Cliente',
          'email'=>'cliente@seguimiento.com',
          'password'=>hash('sha256','123')
        ]);

        /*asignacion de los roles a los usuarios*/
        $role1 =Role::where('slug','admin')->first();
        RoleUser::create([
          'role_id' =>$role1->id,
          'user_id' =>$user1->id
        ]);

        $role2 =Role::where('slug','seller')->first();
        RoleUser::create([
          'role_id' =>$role2->id,
          'user_id' =>$user2->id
        ]);

        $role3 =Role::where('slug','client')->first();
        RoleUser::create([
          'role_id' =>$role3->id,
          'user_id' =>$user3->id
        ]);

        /*asignacion de los menus por rol*/
        $menu_admin =Menu::where('slug','administracion')->first();
        $menu_users =Menu::where('slug','users')->first();
        $menu_permissions =Menu::where('slug','permissions')->first();
        $menu_roles =Menu::where('slug','roles')->first();
        $menu_menus =Menu::where('slug','menus')->first();
        $menu_device =Menu::where('slug','device')->first();
        $menu_geozone =Menu::where('slug','geozone')->first();
        $menu_trackings =Menu::where('slug','trackings')->first();
        $menu_maintenance =Menu::where('slug','maintenance')->first();
        $menu_logaccess =Menu::where('slug','logaccess')->first();

        MenuRol::create([
          'role_id' =>$role1->id,
          'menu_id' =>$menu_admin->id
        ]);
        MenuRol::create([
          'role_id' =>$role1->id,
          'menu_id' =>$menu_users->id
        ]);
        MenuRol::create([
          'role_id' =>$role1->id,
          'menu_id' =>$menu_permissions->id
        ]);
        MenuRol::create([
          'role_id' =>$role1->id,
          'menu_id' =>$menu_roles->id
        ]);
        MenuRol::create([
          'role_id' =>$role1->id,
          'menu_id' =>$menu_menus->id
        ]);

        MenuRol::create([
          'role_id' =>$role2->id,
          'menu_id' =>$menu_device->id
        ]);
        MenuRol::create([
          'role_id' =>$role2->id,
          'menu_id' =>$menu_logaccess->id
        ]);

        MenuRol::create([
          'role_id' =>$role3->id,
          'menu_id' =>$menu_trackings->id
        ]);
        MenuRol::create([
          'role_id' =>$role3->id,
          'menu_id' =>$menu_device->id
        ]);
        MenuRol::create([
          'role_id' =>$role3->id,
          'menu_id' =>$menu_maintenance->id
        ]);
        MenuRol::create([
          'role_id' =>$role3->id,
          'menu_id' =>$menu_logaccess->id
        ]);
    }
}
