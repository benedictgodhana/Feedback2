<?php

namespace App\Http\Controllers;

use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
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


public function showcategories()
{
    // Fetch all categories
    $categories = FeedbackCategory::all();

    // Pass categories to the Inertia view
    return Inertia::render('SuperAdmin/Categories', [
        'categories' => $categories
    ]);
}



public function showsubcategories()
{
    // Fetch all subcategories
    $subcategories = FeedbackSubcategory::with('category')->get();
    // Pass subcategories to the Inertia view
    return Inertia::render('SuperAdmin/SubCategories', [
        'subcategories' => $subcategories
    ]);
}

}
