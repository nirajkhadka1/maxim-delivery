<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $incrementing = true;
    
    protected $fillable= [
        'id',
        'school_id',
        'status',
        'shipping_address',
        'available_delivery_date',
        'remarks',
        'created_at',
        'updated_at'
    ];
}
