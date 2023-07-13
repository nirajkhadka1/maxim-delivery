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

    public function getColumn(string $column_name)
    {
        return Location::select($column_name)->distinct()->get();
        
    }

    public function updateOrInsert(array $condition, array $payload)
    {
       return Location::updateOrCreate($condition,$payload);
    }

    public function update(array $condition, array $payload)
    {
       return Location::where($condition)->update($payload);
    }

    public function getSingle(array $condition)
    {
        return Location::where($condition)->first();
    }

    
}