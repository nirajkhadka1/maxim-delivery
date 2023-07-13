<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $incrementing = true;
    
    protected $fillable= [
        'id',
        'school_id',
        'status',
        'address',
        'delivery_date',
        'remarks',
        'postal_code',
        'geolocation',
        'created_at',
        'updated_at'
    ];
}
