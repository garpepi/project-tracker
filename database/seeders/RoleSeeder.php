<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('http://usersmanage.adi-internal.com/api/auth/roleall');
        $role = json_decode((string) $response->body(), true);
        $getRole = Role::all();
        if ($getRole->isEmpty()) {
            foreach ($role['role'] as $keyrole => $value) {
                Role::create([
                                'id' => $value['id'],
                                'name' => $value['name'],
                            ]);
            }
        }else{
            foreach ($role['role'] as $keyrole => $value) {
                $break = false;
                foreach ($getRole as $key => $item) {
                    if ($value['id'] == $item->id) {
                        $break = true;
                    }
                }
                if ($break == true) {
                }else{
                    Role::create([
                        'id' => $value['id'],
                        'name' => $value['name'],
                    ]);
                }
            }
        }
    }
}
