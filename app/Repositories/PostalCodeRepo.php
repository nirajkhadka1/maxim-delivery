<?php

namespace App\Repositories;

use App\Models\PostalCode;
use App\Repositories\contracts\PostalCodeRepoInterface;

class PostalCodeRepo implements PostalCodeRepoInterface{
    public function insert(array $payload)
    {
        return PostalCode::create($payload);
    }

    public function getAll(){
        return PostalCode::all();
    }

    public function getAllWithLocation(){
        return PostalCode::with('location')->get();
    }
}