<?php

namespace Database\Seeders;

use App\Models\Access_menu;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class AccessmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check1 = Access_menu::all();
        $getRole = Role::all();
        $menus = Menu::all();
        if ($check1->isEmpty()) {
            for ($k=1; $k < count($getRole); $k++) {
                for ($i=1; $i <= count($menus); $i++) {
                    Access_menu::create([
                        'menu_id' => $i,
                        'role_id' => $k,
                        'active' => 1
                    ]);
                }
            }
        }
    }
}
