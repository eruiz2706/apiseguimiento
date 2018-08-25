<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $m1 =Menu::create([
          'name' => 'Administracion',
          'slug' => 'administracion',
          'url' => '#',
          'parent' => 0,
          'order' => 0,
        ]);

        Menu::create([
          'name' => 'Usuarios',
          'slug' => 'users',
          'url' => '/users',
          'parent' => $m1->id,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Permisos',
          'slug' => 'permissions',
          'url' => '/permissions',
          'parent' => $m1->id,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Roles',
          'slug' => 'roles',
          'url' => '/roles',
          'parent' => $m1->id,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Menu',
          'slug' => 'menus',
          'url' => '/menus',
          'parent' => $m1->id,
          'order' => 0,
        ]);

        Menu::create([
          'name' => 'Dispositivos',
          'slug' => 'device',
          'url' => '/devices',
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Geocerca',
          'slug' => 'geozone',
          'url' => '/geozones',
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Seguimiento',
          'slug' => 'trackings',
          'url' => '/trackings',
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Mantenimiento',
          'slug' => 'maintenance',
          'url' => '/maintenances',
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Log de Acceso',
          'slug' => 'logaccess',
          'url' => '/logaccess',
          'order' => 0,
        ]);
    }
}
