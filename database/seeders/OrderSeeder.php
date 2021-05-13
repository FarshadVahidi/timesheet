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
           'name' => 'DEFAULT PROJECT FOR OUR COMPANY',
            'aziende_id' => 1,
            'start' => '2021-01-01',
            'end' => '2021-01-29',
            'days' => 365,
            'cost' => 0,

        ]);
        DB::table('orders')->insert([
            'name' => 'Conbon',
            'aziende_id' => 2,
            'start' => '2021-05-10',
            'end' => '2021-06-10',
            'days' => 10,
            'cost' => 500,
        ]);

        DB::table('orders')->insert([
            'name' => 'Agili',
            'aziende_id' => 2,
            'start' => '2021-05-15',
            'end' => '2021-06-15',
            'days' => 15,
            'cost' => 550,
        ]);

        DB::table('orders')->insert([
            'name' => 'Spiral',
            'aziende_id' => 3,
            'start' => '2021-05-10',
            'end' => '2021-06-10',
            'days' => 10,
            'cost' => 500,
        ]);

        DB::table('orders')->insert([
            'name' => 'Book Shelves',
            'aziende_id' => 3,
            'start' => '2021-05-10',
            'end' => '2021-06-10',
            'days' => 10,
            'cost' => 500,
        ]);
    }
}
