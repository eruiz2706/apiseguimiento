<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable =['name','slug','parent','url','icono','orden','enabled'];

    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }
    public function optionsMenu()
    {
        return $this->where('enabled', 1)
            ->orderby('parent')
            ->orderby('orden')
            ->orderby('name')
            ->get()
            ->toArray();
    }

    public function optionsMenuList()
    {
        return $this->orderby('parent')
            ->orderby('orden')
            ->orderby('name')
            ->get()
            ->toArray();
    }

    public static function menusList()
    {
        $menus = new Menu();
        $data = $menus->optionsMenuList();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];

            if($item[0]['parent'] == 0){
                $menuAll = array_merge($menuAll, $item);
            }
        }
        return $menus->menuAll = $menuAll;
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }
}
