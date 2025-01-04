<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules';

    protected $fillable = [
        'move',
        'vs_move',
        'outcome',
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];
}
