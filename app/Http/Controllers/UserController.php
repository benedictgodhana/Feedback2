<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
{
    $users = User::with(['roles'])->get()->map(function ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'), // Extract only the role names
            
        ];
    });

    return Inertia::render('Users', [
        'users' => $users,
    ]);
}

}
