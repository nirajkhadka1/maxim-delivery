<?php

namespace App\Repositories\contracts;

interface OrdersRepoInterface{
    public function insert(array $payload);
    public function getAll();
    public function getSingle(array $condition);
    public function update(array $payload,array $condition);
}
