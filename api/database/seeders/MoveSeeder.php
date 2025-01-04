<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            ['slug' => 'rock', 'name' => 'Rock'],
            ['slug' => 'paper', 'name' => 'Paper'],
            ['slug' => 'scissors', 'name' => 'Scissors'],
        ];

        DB::table('move')->insert($config);
    }
}
