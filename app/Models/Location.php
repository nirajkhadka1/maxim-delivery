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
        'postal_code_id',
        'geolocation',
        'suburb',
        'config',
        'start_date',
        'order_limit',
        'custom_dates',
        'created_at',
        'updated_at'
    ];

    public function postalCodes()
    {
        return $this->belongsToMany(PostalCode::class);
    }
}
    