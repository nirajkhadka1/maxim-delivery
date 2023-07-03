<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $incrementing = true;
    
    protected $fillable= [
        'id',
        'primary_contact_number',
        'secondary_contact_number',
        'primary_email_address',
        'secondary_email_number',
        'address',
        'created_at',
        'updated_at'
    ];
}
