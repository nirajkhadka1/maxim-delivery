<?php

namespace App\Repositories\contracts;

interface PostalCodeRepoInterface {
    public function insert(array $payload);
    public function getAll();
    public function getAllWithLocation();
}