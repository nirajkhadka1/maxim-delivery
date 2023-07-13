<?php

namespace App\Repositories\contracts;

interface LocationRepoInterface{
    public function insert(array $payload);
    public function getAll();
    public function getColumn(string $column_name);
    public function updateOrInsert(array $condition,array $payload);
    public function getSingle(array $condition);
    public function update(array $condition, array $payload);
}