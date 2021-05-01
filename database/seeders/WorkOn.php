<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkOn extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workon')->insert([
            'user_id' => 3,
            'order_id' => 1,
        ]);
        DB::table('workon')->insert([
            'user_id' => 3,
            'order_id' => 2,
        ]);

        DB::table('workon')->insert([
            'user_id' => 2,
            'order_id' => 1,
        ]);

        DB::table('workon')->insert([
            'user_id' => 2,
            'order_id' => 2,
        ]);

    }
}
