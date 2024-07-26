<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $primaryKey = 'results_id'; // Define the primary key if it's not the default 'id'
    public $timestamps = true; // Set to false if you don't use timestamps

    protected $fillable = [
        'participantName',
        'schoolName',
        'challengeName',
        'timeTaken',
        'questions',
        'answers',
        'totalTime',
        'totalScore',
    ];
}
