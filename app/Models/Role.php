<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Role  extends Model
{

    use HasFactory;
   // User.php
public function roles()
{
    return $this->belongsToMany(Role::class);
}






}
