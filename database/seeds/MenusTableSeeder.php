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
          'name' => 'Opción 1',
          'slug' => 'opcion1',
          'url' => '',
          'parent' => 0,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Opción 2',
          'slug' => 'opcion2',
          'url' => '',
          'parent' => 0,
          'order' => 1,
        ]);
        $m3 =Menu::create([
          'name' => 'Opción 3',
          'slug' => 'opcion3',
          'url' => '',
          'parent' => 0,
          'order' => 2,
        ]);
        $m4 =Menu::create([
          'name' => 'Opción 4',
          'slug' => 'opcion4',
          'url' => '',
          'parent' => 0,
          'order' => 3,
        ]);
        Menu::create([
          'name' => 'Opción 1.1',
          'slug' => 'opcion-1.1',
          'url' => '',
          'parent' => $m1->id,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Opción 1.2',
          'slug' => 'opcion-1.2',
          'url' => '',
          'parent' => $m1->id,
          'order' => 1,
        ]);
        Menu::create([
          'name' => 'Opción 3.1',
          'slug' => 'opcion-3.1',
          'url' => '',
          'parent' => $m3->id,
          'order' => 0,
        ]);
        $m32 =Menu::create([
          'name' => 'Opción 3.2',
          'slug' => 'opcion-3.2',
          'url' => '',
          'parent' => $m3->id,
          'order' => 1,
        ]);
        Menu::create([
          'name' => 'Opción 4.1',
          'slug' => 'opcion-4.1',
          'url' => '',
          'parent' => $m4->id,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Opción 3.2.1',
          'slug' => 'opcion-3.2.1',
          'url' => '',
          'parent' => $m32->id,
          'order' => 0,
        ]);
        Menu::create([
          'name' => 'Opción 3.2.2',
          'slug' => 'opcion-3.2.2',
          'url' => '',
          'parent' => $m32->id,
          'order' => 1,
        ]);
        Menu::create([
          'name' => 'Opción 3.2.3',
          'slug' => 'opcion-3.2.3',
          'url' => '',
          'parent' => $m32->id,
          'order' => 2,
        ]);
    }
}
