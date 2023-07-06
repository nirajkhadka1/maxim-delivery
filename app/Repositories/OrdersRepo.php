<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\contracts\OrdersRepoInterface;

class OrdersRepo implements OrdersRepoInterface{
    public function insert(array $payload)
    {
       return Order::insert($payload);
    }
    
    public function getAll(){
        return Order::orderBy('updated_at','DESC')->paginate(10);
    }

    public function getSingle(array $condition){
        return Order::where($condition)->first();
    }
}