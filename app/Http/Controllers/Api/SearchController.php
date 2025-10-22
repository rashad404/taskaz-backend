<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Unified search across tasks, professionals, and categories
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 5);

        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'tasks' => [],
                    'professionals' => [],
                    'categories' => [],
                ],
                'total' => 0
            ]);
        }

        // Search Tasks
        $tasks = Task::where('status', 'open')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->with(['client', 'category'])
            ->limit($limit)
            ->get(['id', 'slug', 'user_id', 'category_id', 'title', 'description', 'budget_type', 'budget_amount', 'location', 'is_remote', 'created_at']);

        // Search professionals
        $professionals = User::whereIn('type', ['professional', 'both'])
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('bio', 'like', '%' . $query . '%')
                  ->orWhere('location', 'like', '%' . $query . '%');
            })
            ->withCount(['receivedReviews as total_reviews'])
            ->withAvg('receivedReviews as average_rating', 'rating')
            ->limit($limit)
            ->get(['id', 'slug', 'name', 'avatar', 'bio', 'location']);

        // Round average rating
        $professionals->each(function($professional) {
            if ($professional->average_rating) {
                $professional->average_rating = round($professional->average_rating, 1);
            }
        });

        // Search Categories
        $categories = Category::where('is_active', true)
            ->where('name', 'like', '%' . $query . '%')
            ->limit($limit)
            ->get(['id', 'name', 'slug', 'icon']);

        $total = $tasks->count() + $professionals->count() + $categories->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'tasks' => $tasks,
                'professionals' => $professionals,
                'categories' => $categories,
            ],
            'total' => $total
        ]);
    }
}
