<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\contracts\OrdersRepoInterface;

class OrdersRepo implements OrdersRepoInterface
{
    public function insert(array $payload)
    {
        return Order::insert($payload);
    }

    public function getAll()
    {
        return Order::with('school')->orderBy('updated_at','DESC')->get();
    }

    public function getSingle(array $condition)
    {
        return Order::where($condition)->first();
    }

    public function getCount(array $condition)
    {
        return Order::where($condition)->count();
    }

    public function update(array $payload, array $condition)
    {
        Order::where($condition)->update($payload);
    }

    public function getOrderExceedsDate(array $condition, string $field,string $have_condition)
    {
        return Order::select('delivery_date')->where($condition)->groupBy($field)->havingRaw($have_condition)->pluck('delivery_date')->toArray();
    }
}
