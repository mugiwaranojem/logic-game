<?php
namespace App\Services;

use App\Models\Move;
use App\Http\Resources\MoveCollectionResource;

class MoveService
{
    public function all()
    {
        return new MoveCollectionResource(Move::all());
    }
}