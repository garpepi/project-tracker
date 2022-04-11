<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkB = Type::where('name', 'Blanket')->first();
        if ($checkB === null) {
            Type::create([
                'name' => 'Blanket',
                'display' => 'block',
                'required' => 1,
            ]);
        }
        $checkQ = Type::where('name', 'Blanket Quantity Global')->first();
        if ($checkQ === null) {
            Type::create([
                'name' => 'Blanket Quantity Global',
                'display' => 'block',
                'required' => 1,
            ]);
        }
        $checkV = Type::where('name', 'Blanket Total Value Global')->first();
        if ($checkV === null) {
            Type::create([
                'name' => 'Blanket Total Value Global',
                'display' => 'block',
                'required' => 1,
            ]);
        }
        $checkP = Type::where('name', 'Non Blanket')->first();
        if ($checkP === null) {
            Type::create([
                'name' => 'Non Blanket',
                'display' => 'none',
                'required' => 0,
            ]);
        }
    }
}
