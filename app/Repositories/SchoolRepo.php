<?php 

namespace App\Repositories;

use App\Models\School;
use App\Repositories\contracts\SchoolRepoInterface;

class SchoolRepo implements SchoolRepoInterface{
    public function insert(array $payload)
    {
        return School::create($payload);
    }
} 