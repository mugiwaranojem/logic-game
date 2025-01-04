<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            ['key' => 'player_number', 'value' => '2'],
            ['key' => 'rounds', 'value' => '10'],
        ];

        DB::table('game_config')->insert($config);
    }
}
