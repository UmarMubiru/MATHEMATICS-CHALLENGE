<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'emailAddress',
        'dateOfBirth',
        'schoolRegistrationNumber',
        'imageFile' // Add other fillable attributes here if needed
    ];

}
