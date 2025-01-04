<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scenarios = [
            ['move' => 'rock', 'vs_move' => 'rock', 'outcome' => 'draw'],
            ['move' => 'rock', 'vs_move' => 'paper', 'outcome' => 'lose'],
            ['move' => 'rock', 'vs_move' => 'scissors', 'outcome' => 'win'],
            ['move' => 'paper', 'vs_move' => 'rock', 'outcome' => 'win'],
            ['move' => 'paper', 'vs_move' => 'paper', 'outcome' => 'draw'],
            ['move' => 'paper', 'vs_move' => 'scissors', 'outcome' => 'lose'],
            ['move' => 'scissors', 'vs_move' => 'rock', 'outcome' => 'lose'],
            ['move' => 'scissors', 'vs_move' => 'paper', 'outcome' => 'win'],
            ['move' => 'scissors', 'vs_move' => 'scissors', 'outcome' => 'draw'],
        ];

        DB::table('rules')->insert($scenarios);
    }
}
