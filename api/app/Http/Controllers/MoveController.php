<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\MoveService;

class MoveController extends Controller
{
    public function __construct(
        private readonly MoveService $moveService
    ) {
    }

    public function all(Request $request)
    {
        return $this->moveService->all();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => ['required', 'unique:move,slug'],
            'name' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        $slug = $request->get('slug');
        $name = $request->get('name');
        return $this->moveService->create([
            'slug' => $slug,
            'name' => $name
        ]);
    }
}