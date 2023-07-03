<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDate extends Model
{
    use HasFactory;

    public $incrementing = true;
    
    protected $casts = [
        'dates' => 'date',
    ];
    protected $fillable= [
        'id',
        'dates',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getDatesAttribute($value)
    {
        // Customize the date format as per your requirement
        $date = Carbon::parse($value)->format('Y-m-d');
        
        return $date;
    }
    public function setDatesAttribute($value)
    {
        // Customize the date format as per your requirement
        $this->attributes['dates'] = date('Y-m-d', strtotime($value));

    }
}
