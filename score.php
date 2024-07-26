<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['participant_id', 'challenge_id', 'score', 'school_id'];

    public function school()
    {
        return $this->belongsTo(Schools::class);
    }
    
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
