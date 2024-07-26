<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $primaryKey = 'question_id'; // Set the primary key field
    public $incrementing = true; // Ensure it's auto-incrementing
    protected $keyType = 'int'; // Define the key type
protected $table = 'questions';

// Specify which fields can be mass-assigned
protected $fillable = ['questions', 'marks'];
}
