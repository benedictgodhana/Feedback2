<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
use Carbon\Carbon;
use App\Models\Notification;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total users count
        $totalUsers = User::count();
        $totalCategories = FeedbackCategory::count();
        $totalSubCategories = FeedbackSubcategory::count();
        $totalRole = Role::count();



        // Fetch feedback counts
        $todaysFeedback = Feedback::whereDate('created_at', Carbon::today())->count();
        $weeksFeedback = Feedback::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyFeedback = Feedback::whereMonth('created_at', Carbon::now()->month)->count();

        // Fetch feedback categories and their feedback counts
        $categories = FeedbackCategory::withCount('feedbacks')->get();

        $totalFeedback = Feedback::count(); // Total feedback count
        // Prepare categories data with URLs
        $categoriesData = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'feedback_count' => $category->feedbacks_count,
                'icon' => $category->icon ?? 'mdi-comment', // Provide default icon if not set
                'url' => route('category.feedback', ['categoryId' => $category->id]), // Use 'categoryId' here
            ];
        });

        // Prepare data for the feedback chart
        $feedbackChartData = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'data' => $category->feedbacks_count,
            ];
        });

        // Return data using Inertia
        return Inertia::render('Dashboard', [
            'totalUsers' => $totalUsers,
            'todaysFeedback' => $todaysFeedback,
            'weeksFeedback' => $weeksFeedback,
            'monthlyFeedback' => $monthlyFeedback,
            'categories' => $categoriesData,
            'feedbackChartData' => $feedbackChartData, // Send chart data
            'totalFeedback' => $totalFeedback, // Include total feedback count
            'TotalCategories'=>$totalCategories,
            'TotalSubCategories'=>$totalSubCategories,
            'TotalRoles'=>$totalRole

        ]);
    }
}

