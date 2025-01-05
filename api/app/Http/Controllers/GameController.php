<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GameLogicService;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function __construct(
        private readonly GameLogicService $gameService
    ) {
    }

    public function executeRound(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'move' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $move = $request->get('move');
        try {
            return response()->json([
                'result' => $this->gameService->executeRound($move)
            ]);
        } catch (\App\Exceptions\RuleNotSupportedException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'missing_rules' => $this->gameService->getMissingMoveRules($move)
            ], 400);
        }
    }

    public function analyse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_win_count' => ['required', 'integer'],
            'computer_win_count' => ['required', 'integer'],
            'draw_count' => ['required', 'integer'],
            'rounds' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $playerWinCount = $request->get('player_win_count');
        $computerWinCount = $request->get('computer_win_count');
        $drawCount = $request->get('draw_count');
        $rounds = $request->get('rounds');
        return response()->json([
            'result' => $this->gameService->analyseGame(
                $playerWinCount,
                $computerWinCount,
                $drawCount,
                $rounds
            )
        ]);
    }
}
