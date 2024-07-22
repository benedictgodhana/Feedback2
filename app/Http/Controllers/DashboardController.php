<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contribution;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count(); // Total users count
        $totalContributions = Contribution::sum('amount'); // Total contributions amount
        $monthlyCollection = Contribution::whereMonth('created_at', now()->month)->sum('amount'); // Monthly collection amount

        $contributionsData = Contribution::select('amount')
            ->orderBy('created_at')
            ->limit(9) // Limit to last 9 months or periods
            ->pluck('amount')
            ->toArray();

        return Inertia::render('Dashboard', [
            'totalUsers' => $totalUsers,
            'totalContributions' => $totalContributions,
            'monthlyCollection' => $monthlyCollection,
            'contributionsData' => $contributionsData,
        ]);
    }
}

