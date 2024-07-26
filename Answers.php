<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;
    

    protected $table = 'answers';

    protected $fillable = [
        'answers',

    ];

    public function question()
    {
        return $this->belongsTo(Questions::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
