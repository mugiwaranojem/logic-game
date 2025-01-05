<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GameLogicService;
use App\Models\Move;
use App\Models\Rule;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameLogicServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Move::factory()->create(['slug' => 'rock', 'name' => 'Rock']);
        Move::factory()->create(['slug' => 'paper', 'name' => 'Paper']);
        Move::factory()->create(['slug' => 'scissors', 'name' => 'Scissors']);

        Rule::factory()->create([
            'move' => 'rock',
            'vs_move' => 'scissors',
            'outcome' => 'win'
        ]);

        Rule::factory()->create([
            'move' => 'rock',
            'vs_move' => 'paper',
            'outcome' => 'lose'
        ]);

        Rule::factory()->create([
            'move' => 'rock',
            'vs_move' => 'rock',
            'outcome' => 'draw'
        ]);
    }

    /** @test */
    public function it_executes_a_round_and_returns_correct_outcome()
    {
        $gameLogicService = new GameLogicService();

        $result = $gameLogicService->executeRound('rock');

        $this->assertArrayHasKey('player_move', $result);
        $this->assertArrayHasKey('computer_move', $result);
        $this->assertArrayHasKey('outcome', $result);

        $this->assertInstanceOf(\App\Http\Resources\MoveResource::class, $result['player_move']);
        $this->assertInstanceOf(\App\Http\Resources\MoveResource::class, $result['computer_move']);
        $this->assertContains($result['outcome'], ['win', 'lose', 'draw']);
    }

    /** @test */
    public function it_analyzes_the_game_and_returns_correct_statistics()
    {
        $gameLogicService = new GameLogicService();

        $result = $gameLogicService->analyseGame(3, 2, 1, 6);

        $this->assertEquals(3, $result['player_win_count']);
        $this->assertEquals(2, $result['computer_win_count']);
        $this->assertEquals(1, $result['draw_count']);
        $this->assertEquals(6, $result['rounds']);
        $this->assertEquals('50.00', $result['player_win_percentage']);
        $this->assertEquals('33.33', $result['computer_win_percentage']);
    }
}