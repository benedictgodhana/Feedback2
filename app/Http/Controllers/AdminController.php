<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\User;
use App\Models\Contribution;
use Carbon\Carbon;
use App\Models\Notification;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch total users count
        $totalUsers = User::count();

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
        return Inertia::render('Admin/AdminIndex', [
            'totalUsers' => $totalUsers,
            'todaysFeedback' => $todaysFeedback,
            'weeksFeedback' => $weeksFeedback,
            'monthlyFeedback' => $monthlyFeedback,
            'categories' => $categoriesData,
            'feedbackChartData' => $feedbackChartData, // Send chart data
            'totalFeedback' => $totalFeedback, // Include total feedback count
        ]);
    }
    public function users(): Response
    {
        $user = auth()->user(); // Assuming you're using Laravel's authentication
        $errors = []; // Example empty errors array

        return Inertia::render('Users', [
            'auth' => [
                'user' => $user,
            ],
            'errors' => $errors,
        ]);
    }

    public function manageRoles(): Response
    {
        return Inertia::render('ManageRoles');
    }

    public function contributions()
{

    return Inertia::render('Contributions');
}

    public function dashboard(): Response
    {
        return Inertia::render('Dashboard');
    }

    public function adminProfile(): Response
    {
        return Inertia::render('Admin/Profile');
    }



    public function adminContribution(): Response
    {
        return Inertia::render('Admin/Contribution');
    }

    public function adminNotification(): Response
    {
        $notifications = Notification::with(['feedback.category', 'feedback.subcategory'])->get();
        $feedbacks = Feedback::with(['category', 'subcategory'])->get(); // Ensure you have a Feedback model

        return Inertia::render('Admin/Notifications', [
            'notifications' => $notifications,
            'feedbacks' => $feedbacks,
        ]);
    }



    public function adminSetting(): Response
    {
        return Inertia::render('Admin/Settings');
    }


    public function categoryFeedback($id)
    {
        // Fetch feedbacks for a specific category
        $category = FeedbackCategory::findOrFail($id);
        $feedbacks = $category->feedbacks;

        return Inertia::render('Feedback/CategoryFeedback', [
            'category' => $category,
            'feedbacks' => $feedbacks,
        ]);
    }

}
