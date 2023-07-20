<?php

namespace App\Repositories\contracts;

interface OrdersRepoInterface{
    public function insert(array $payload);
    public function getAll();
    public function getSingle(array $condition);
    public function update(array $payload,array $condition);
    public function getCount(array $condition);
    public function getOrderExceedsDate(string $start_date,string $end_date, string $geolocation,int $order_limit);
}
