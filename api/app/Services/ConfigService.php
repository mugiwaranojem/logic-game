<?php
namespace App\Services;

use App\Models\GameConfig;

class ConfigService
{
    public function getConfig(): array
    {
        $playerCount = GameConfig::where('key', 'player_number')->first()?->value;
        $rounds = GameConfig::where('key', 'rounds')->first()?->value;
        return [
            'players_count' => $playerCount,
            'rounds' => $rounds
        ];
    }

    public function updateConfigByKey(string $key, string $value): ?GameConfig
    {
        $config = GameConfig::where('key', $key)->first();
        if ($config) {
            $config->value = $value;
            $config->save();
        }
        return $config;
    }
}