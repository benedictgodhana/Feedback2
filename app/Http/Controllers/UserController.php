<?php

namespace App\Http\Controllers;

use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Mail\UserLoginDetails;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    public function index()
    {
        // Fetch all roles using Spatie's Role model
        $roles = Role::all()->pluck('name');

        // Fetch all users with their roles
        $users = User::with(['roles'])->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'), // Extract only the role names
            ];
        });

        // Pass both users and roles to the Inertia component
        return Inertia::render('Users', [
            'users' => $users,
            'roles' => $roles, // Add roles here
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
public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'roles' => 'required|string|exists:roles,name' // Validate that roles is a single valid role
    ]);

    try {
        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Attach the single role to the user
        $roleId = Role::where('name', $validatedData['roles'])->first()->id;
        $user->roles()->attach($roleId);

        // Send email with login details
        Mail::to($user->email)->send(new UserLoginDetails($user, $validatedData['password']));


    } catch (\Exception $e) {
        // Log the exception and return a generic error message
        \Log::error('Error creating user: ' . $e->getMessage());
        return response()->json(['error' => 'Error creating user'], 500);
    }
}


public function destroy($id)
{
    $user = User::find($id);
    if ($user) {
        $user->delete();
    }
}

}
