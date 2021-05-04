<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AziendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aziende')->insert([
            'p_iva' => Str::random(10),
            'name' => 'its prodigy',
        ]);
        DB::table('aziende')->insert([
            'p_iva' => Str::random(10),
            'name' => 'second',
        ]);
        DB::table('aziende')->insert([
            'p_iva' => Str::random(10),
            'name' => 'thierd',
        ]);
    }
}
