<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $incrementing = true;
    
    protected $fillable= [
        'id',
        'postal_code',
        'geolocation',
        'created_at',
        'updated_at'
    ];
}
    