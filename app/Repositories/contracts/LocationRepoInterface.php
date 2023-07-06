<?php

namespace App\Repositories\contracts;

interface LocationRepoInterface{
    public function insert(array $payload);
    public function getAll();
}