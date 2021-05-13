<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'status' => 'nuovo'
        ]);
        DB::table('statuses')->insert([
            'status' => 'usato in ottime condizioni'
        ]);
        DB::table('statuses')->insert([
            'status' => 'condizioni'
        ]);
        DB::table('statuses')->insert([
            'status' => 'usato con graffi'
        ]);
    }
}
