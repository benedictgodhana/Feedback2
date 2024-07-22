<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Mail\WelcomeEmail;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'surname' => 'required|string|max:255',
            'otherNames' => 'required|string|max:255',
            'dept' => 'required|string|max:255',
            'employmentType' => 'nullable|string|max:255',
            'employeeNo' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
            'sex' => 'required|string|max:10',
            'religion' => 'required|string|max:50',
            'telR' => 'required|string|max:15',
            'telCell' => 'required|string|max:15',
            'currentAddress' => 'required|string|max:255',
            'residence' => 'nullable|string|max:255',
            'postalAddress' => 'nullable|string|max:255',
            'homeDistrict' => 'nullable|string|max:255',
            'fatherName' => 'nullable|string|max:255',
            'fatherDOB' => 'nullable|date',
            'fatherOccupation' => 'nullable|string|max:255',
            'motherName' => 'nullable|string|max:255',
            'motherDOB' => 'nullable|date',
            'motherOccupation' => 'nullable|string|max:255',
            'maritalStatus' => 'required|string|max:10',
            'spouseName' => 'nullable|string|max:255',
            'dateOfMarriage' => 'nullable|date',
            'spouseTel' => 'nullable|string|max:15',
            'children' => 'nullable|array',
            'children.*.name' => 'nullable|string|max:255',
            'children.*.dob' => 'nullable|date',
            'siblings' => 'nullable|array',
            'siblings.*.name' => 'nullable|string|max:255',
            'siblings.*.dob' => 'nullable|date',
            'signedPdf' => 'nullable|file|mimes:pdf|max:2048',
            'agree' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('signedPdf')) {
            $filePath = $request->file('signedPdf')->store('signed_pdfs', 'public');
        }

        $userProfile = UserProfile::create([
            'user_id' => $user->id,
            'surname' => $request->surname,
            'otherNames' => $request->otherNames,
            'dept' => $request->dept,
            'employmentType' => $request->employmentType,
            'employeeNo' => $request->employeeNo,
            'dateOfBirth' => $request->dateOfBirth,
            'sex' => $request->sex,
            'religion' => $request->religion,
            'telR' => $request->telR,
            'telCell' => $request->telCell,
            'currentAddress' => $request->currentAddress,
            'residence' => $request->residence,
            'postalAddress' => $request->postalAddress,
            'homeDistrict' => $request->homeDistrict,
            'fatherName' => $request->fatherName,
            'fatherDOB' => $request->fatherDOB,
            'fatherOccupation' => $request->fatherOccupation,
            'motherName' => $request->motherName,
            'motherDOB' => $request->motherDOB,
            'motherOccupation' => $request->motherOccupation,
            'maritalStatus' => $request->maritalStatus,
            'spouseName' => $request->spouseName,
            'dateOfMarriage' => $request->dateOfMarriage,
            'spouseTel' => $request->spouseTel,
            'children' => json_encode($request->children),
            'siblings' => json_encode($request->siblings),
            'signedPdf' => $filePath, // Save the file path
            'agree' => $request->agree, // Save the agree field
        ]);

        // Assign the "member" role to the user
        $role = Role::where('name', 'member')->first();
        if ($role) {
            $user->assignRole($role);
        }

        event(new Registered($user));

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
