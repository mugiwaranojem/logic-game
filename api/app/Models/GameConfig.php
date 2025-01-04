<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameConfig extends Model
{
    use HasFactory;

    protected $table = 'game_config';

    protected $fillable = [
        'key',
        'value',
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];
}
