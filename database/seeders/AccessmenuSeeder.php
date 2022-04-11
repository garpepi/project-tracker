<?php

namespace Database\Seeders;

use App\Models\Access_menu;
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
        if ($check1->isEmpty()) {
            for ($i=1; $i <= 12; $i++) {
                Access_menu::create([
                    'menu_id' => $i,
                    'role_id' => 1,
                    'active' => 1
                ]);
            }
        }
    }
}
