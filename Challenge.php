<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'open_date',
        'close_date',
        'duration',
        'no_of_questions' // Add other fillable attributes here if needed
    ];
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

}
