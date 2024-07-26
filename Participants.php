<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'school_id'];
    public function school()
    {
        return $this->belongsTo(Schools::class);
    }

    public function answers()
    {
        return $this->hasMany(Answers::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
