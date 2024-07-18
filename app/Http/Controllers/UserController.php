<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

// UserController.php

// UserController.php
public function update(Request $request, User $user)
{
    // Validate other fields (name, email, password, etc.)
    // ...

    $selectedRoleId = $request->input('role'); // Get the selected role ID

    // Update user's role
    $user->roles()->sync([$selectedRoleId]);

    // Redirect or return a response
    // ...
}


// UserController.php
public function edit(User $user)
{
    $roles = Role::all(); // Retrieve all roles
    // Other logic for fetching user data...
    return view('users.edit', compact('user', 'roles'));
}



}
