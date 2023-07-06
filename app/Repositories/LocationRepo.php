<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\contracts\LocationRepoInterface;

class LocationRepo implements LocationRepoInterface{
    public function insert(array $payload)
    {
        Location::insert($payload);
    }
    public function getAll()
    {
        return Location::all();
    }
}