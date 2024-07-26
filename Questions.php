<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'questions',
        'marks',
    ];

    public function answers()
    {
        return $this->hasMany(Answers::class);
    }
} 
