<?php

namespace Database\Seeders;

use App\Models\Progress_status;
use Illuminate\Database\Seeder;

class ProgressStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkP = Progress_status::where('status','inProgress')->first();
        if ($checkP === null) {
            Progress_status::create([
                'status' => 'inProgress',
            ]);
        }
        $checkC = Progress_status::where('status','Completed')->first();
        if ($checkC === null) {
            Progress_status::create([
                'status' => 'Completed',
            ]);
        }
    }
}
