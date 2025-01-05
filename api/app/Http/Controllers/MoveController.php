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
}