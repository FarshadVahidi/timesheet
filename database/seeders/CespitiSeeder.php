<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CespitiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cespiti')->insert([
            'categoris_id' => 1,
            'serialnumber' =>'0123456789',
            'marco' => 'mac',
            'modello' => 'p201',
            'status_id' => 1,
            'costo' => '200',
            'user_id' => null,
            'acquisto' => Carbon::now(),
        ]);
    }
}
