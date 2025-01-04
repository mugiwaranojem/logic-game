<?php
namespace App\Services;

use App\Models\GameConfig;
use App\Models\Move;
use App\Models\Rule;
use App\Http\Resources\MoveResource;

class GameLogicService
{
    public function executeRound(string $move): array
    {
        $random = $this->getRadomPlayerMove();
        $result = Rule::where('move', $move)
            ->where('vs_move', $random->slug)
            ->first();
        $playerMove = Move::where('slug', $move)->first();
        return [
            'player_move' => new MoveResource($playerMove),
            'computer_move' => new MoveResource($random),
            'outcome' => $result->outcome
        ];
    }

    private function getRadomPlayerMove()
    {
        $moves = Move::all();
        return $moves->random();
    }

    public function analyseGame(
        int $playerWinCount,
        int $computerWinCount,
        int $drawCount,
        int $rounds
    ): array {
        return [
            'player_win_percentage' => $this->computeWinningPercentage($playerWinCount, $rounds),
            'computer_win_percentage' => $this->computeWinningPercentage($computerWinCount, $rounds),
            'draw_count' => $drawCount,
            'rounds' => $rounds
        ];
    }

    private function computeWinningPercentage(int $winCount, int $rounds)
    {
        $percentage = $winCount / $rounds * 100;
        return number_format($percentage, 2);
    }
}