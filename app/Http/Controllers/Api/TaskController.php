<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with filtering.
     */
    public function index(Request $request)
    {
        $query = Task::with(['client', 'category', 'city'])
            ->where('status', 'open');

        // Filter by category (supports both ID and slug)
        if ($request->has('category')) {
            $category = \App\Models\Category::where('slug', $request->category)
                ->orWhere('id', $request->category)
                ->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Legacy support for category_id parameter
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by budget type
        if ($request->has('budget_type')) {
            $query->where('budget_type', $request->budget_type);
        }

        // Filter by location or remote
        if ($request->has('is_remote')) {
            $query->where('is_remote', $request->boolean('is_remote'));
        }

        // Filter by city
        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Filter by neighborhood
        if ($request->has('neighborhood_id')) {
            $query->where('neighborhood_id', $request->neighborhood_id);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search in title and description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate($request->get('per_page', 20));

        // Add is_owner flag to each task
        $tasks->getCollection()->transform(function ($task) {
            $taskData = $task->toArray();
            $taskData['is_owner'] = Auth::check() && $task->user_id === Auth::id();
            return $taskData;
        });

        return response()->json([
            'status' => 'success',
            'data' => $tasks
        ]);
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget_type' => 'required|in:fixed,hourly',
            'budget_amount' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'neighborhood_id' => 'nullable|exists:neighborhoods,id',
            'is_remote' => 'boolean',
            'deadline' => 'nullable|date|after:today',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        ]);

        // Handle file uploads
        $uploadedFiles = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;

                // Store file in storage/app/public/tasks
                $path = $file->storeAs('tasks', $filename, 'public');

                $uploadedFiles[] = [
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'path' => $path,
                    'url' => config('app.url') . '/storage/' . $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        // Generate unique slug from title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;

        while (Task::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';
        $validated['views_count'] = 0;
        $validated['attachments'] = !empty($uploadedFiles) ? $uploadedFiles : null;

        $task = Task::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $task->load(['client', 'category', 'city'])
        ], 201);
    }

    /**
     * Display the specified task.
     * Supports both ID and slug lookup
     */
    public function show($identifier)
    {
        // Check if identifier is numeric (ID) or string (slug)
        if (is_numeric($identifier)) {
            $task = Task::with([
                'client',
                'category',
                'city',
                'applications' => function($query) {
                    $query->where('status', 'pending')
                          ->with('professional')
                          ->latest();
                }
            ])->findOrFail($identifier);
        } else {
            $task = Task::with([
                'client',
                'category',
                'city',
                'applications' => function($query) {
                    $query->where('status', 'pending')
                          ->with('professional')
                          ->latest();
                }
            ])->where('slug', $identifier)->firstOrFail();
        }

        // Increment views
        $task->incrementViews();

        // Add ownership flag
        $taskData = $task->toArray();
        $taskData['is_owner'] = Auth::check() && $task->user_id === Auth::id();

        return response()->json([
            'status' => 'success',
            'data' => $taskData
        ]);
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Check if user owns this task
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Cannot update if task is not open
        if ($task->status !== 'open') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot update task that is not open'
            ], 400);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'budget_type' => 'sometimes|in:fixed,hourly',
            'budget_amount' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'neighborhood_id' => 'nullable|exists:neighborhoods,id',
            'is_remote' => 'boolean',
            'deadline' => 'nullable|date|after:today',
        ]);

        $task->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'data' => $task->load(['client', 'category', 'city'])
        ]);
    }

    /**
     * Remove the specified task.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Check if user owns this task
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Cannot delete if task has applications
        if ($task->applications()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete task with applications'
            ], 400);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ]);
    }

    /**
     * Get tasks posted by authenticated user.
     */
    public function myTasks(Request $request)
    {
        $tasks = Task::where('user_id', Auth::id())
            ->with(['category', 'applications'])
            ->latest()
            ->paginate($request->get('per_page', 20));

        // Add is_owner flag to each task (always true for myTasks)
        $tasks->getCollection()->transform(function ($task) {
            $taskData = $task->toArray();
            $taskData['is_owner'] = true; // Always true since these are user's own tasks
            return $taskData;
        });

        return response()->json([
            'status' => 'success',
            'data' => $tasks
        ]);
    }
}
