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


public function render()
{
    $roles = Role::all();
    return view('livewire.admin.user.update', [
        'roles' => $roles,
        'user' => $this->user,
    ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('User') ])]);
}




}
