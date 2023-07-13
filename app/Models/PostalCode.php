<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    use HasFactory;

    public $incrementing = true;
    
    protected $fillable= [
        'id',
        'location_id',
        'code',
        'suburb',
        'created_at',
        'updated_at'
    ];
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
