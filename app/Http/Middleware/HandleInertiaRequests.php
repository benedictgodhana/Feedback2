<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\FeedbackCategory;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
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
            'categories' => function () {
                return FeedbackCategory::all()->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'icon' => $category->icon ?? 'mdi-feedback',
                        'url' => route('category.feedback', ['categoryId' => $category->id]),
                    ];
                });
            },
        ]);
    }


    }
