<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\FeedbackCategory;
use Illuminate\Support\Facades\Log; // Import Log facade

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        // Fetch categories
        $categories = FeedbackCategory::all();
        Log::info('Raw Categories:', $categories->toArray());

        // Transform categories for frontend
        $categoriesTransformed = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'icon' => $category->icon ?? 'mdi-feedback', // Ensure 'icon' is defined in your model
                'url' => route('category.feedback', ['categoryId' => $category->id]),
            ];
        })->toArray();
        Log::info('Transformed Categories:', $categoriesTransformed);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => function () use ($request) {
                    if ($user = $request->user()) {
                        return array_merge($user->only('id', 'name', 'email'), [
                            'roles' => $user->getRoleNames(),
                            'permissions' => $user->getAllPermissions()->pluck('name'),
                        ]);
                    }
                    return null;
                },
            ],
            'feedbackCategories' => $categoriesTransformed, // Pass transformed categories
        ]);
    }
}
