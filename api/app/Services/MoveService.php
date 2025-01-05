<?php
namespace App\Services;

use App\Models\Move;
use App\Http\Resources\MoveCollectionResource;
use App\Http\Resources\MoveResource;

class MoveService
{
    public function all()
    {
        return new MoveCollectionResource(Move::all());
    }

    public function create(array $data)
    {
        $move = Move::create([
            'slug' => $data['slug'],
            'name' => $data['name'],
        ]);
        return new MoveResource($move);
    }
}