<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;

class memberController extends Controller
{


    public function contribution()
    {
        return Inertia::render('MemberContribution');
    }

    public function notifications()
    {
        return Inertia::render('MemberNotifications');
    }

    public function settings()
    {
        return Inertia::render('Membersettings');
    }

}
