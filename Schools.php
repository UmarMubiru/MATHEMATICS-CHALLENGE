<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district',
        'registration_number',
        'email',
        'representative'
        // Add other fields here
    ];
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
