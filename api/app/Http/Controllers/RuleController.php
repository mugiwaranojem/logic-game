<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\RuleService;

class RuleController extends Controller
{
    public function __construct(
        private readonly RuleService $ruleService
    ) {
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'move' => ['required', 'string'],
            'vs_move' => ['required', 'string'],
            'outcome' => ['required', 'in:win,lose,draw']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        $move = $request->get('move');
        $vsMove = $request->get('vs_move');
        $outcome = $request->get('outcome');
        return $this->ruleService->create([
            'move' => $move,
            'vs_move' => $vsMove,
            'outcome' => $outcome
        ]);
    }
}