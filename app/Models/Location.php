<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $incrementing = true;
    
    protected $fillable= [
        'id',
        'postal_code',
        'address',
        'created_at',
        'updated_at'
    ];
}
