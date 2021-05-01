<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'name' => 'test project1 SECOND',
            'aziende_id' => 2,
            'start' => '2021-05-10',
            'end' => '2021-06-10',
            'days' => 10,
            'cost' => 500,
        ]);

        DB::table('orders')->insert([
            'name' => 'test project2 SECOND',
            'aziende_id' => 2,
            'start' => '2021-05-15',
            'end' => '2021-06-15',
            'days' => 15,
            'cost' => 550,
        ]);

        DB::table('orders')->insert([
            'name' => 'test project1 THIRD',
            'aziende_id' => 3,
            'start' => '2021-05-10',
            'end' => '2021-06-10',
            'days' => 10,
            'cost' => 500,
        ]);

        DB::table('orders')->insert([
            'name' => 'test project2 THIRD',
            'aziende_id' => 3,
            'start' => '2021-05-10',
            'end' => '2021-06-10',
            'days' => 10,
            'cost' => 500,
        ]);
    }
}
