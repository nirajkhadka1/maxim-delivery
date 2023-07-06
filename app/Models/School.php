<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    public $incrementing = true;
    
    protected $fillable= [
        'id',
        'name',
        'primary_contact_number',
        'secondary_contact_number',
        'primary_email_address',
        'secondary_email_address',
        'address',
        'created_at',
        'updated_at'
    ];

    public function orders(){
        return $this->hasMany(School::class);
    }
}
