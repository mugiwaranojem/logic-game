<?php

namespace App\Http\Controllers;

use App\Services\ConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function __construct(
        private readonly ConfigService $configService
    ) {
    }

    public function getConfig(Request $request)
    {
        return response()->json([
            'config' => $this->configService->getConfig()
        ]);
    }

    public function updateConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $key = $request->get('key');
        $value = $request->get('value');
        return response()->json([
            'result' => $this->configService->updateConfigByKey(
                $key,
                $value
            )
        ]);
    }
}