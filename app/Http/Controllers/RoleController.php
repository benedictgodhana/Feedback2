<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all(); // Fetch all roles from the database

        return Inertia::render('ManageRoles', [
            'roles' => $roles,
        ]);
    }
}
