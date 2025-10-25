<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of active categories.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        return response()->json($categories);
    }

    /**
     * Display the specified category with its subcategories.
     */
    public function show($id)
    {
        $category = Category::with(['children', 'tasks' => function($query) {
            $query->where('status', 'open')->latest()->take(10);
        }])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }
}
