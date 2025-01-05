<?php
namespace App\Services;

use App\Models\Rule;
use App\Http\Resources\RuleResource;

class RuleService
{
    public function create(array $data)
    {
        $rule = Rule::create([
            'move' => $data['move'],
            'vs_move' => $data['vs_move'],
            'outcome' => $data['outcome']
        ]);
        return new RuleResource($rule);
    }
}