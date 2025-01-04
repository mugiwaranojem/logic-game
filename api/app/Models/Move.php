<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;

    protected $table = 'move';
    protected $fillable = [
        'name',
        'slug',
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];
}
