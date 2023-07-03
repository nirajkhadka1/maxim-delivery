<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    public $incrementing = true;
    
    protected $fillable= [
        'id',
        'action',
        'name',
        'payload',
        'remarks',
        'created_at',
        'updated_at'
    ];
}
