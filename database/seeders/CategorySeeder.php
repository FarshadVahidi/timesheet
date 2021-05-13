<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categoris')->insert([
            'name' => 'notebook',
        ]);
        DB::table('categoris')->insert([
            'name' => 'pc',
        ]);
        DB::table('categoris')->insert([
            'name' => 'telefoni'
        ]);
//        DB::table('categoris')->insert([
//            'name' => 'office'
//        ]);
        DB::table('categoris')->insert([
           'name' => 'accessori'
        ]);
    }
}
