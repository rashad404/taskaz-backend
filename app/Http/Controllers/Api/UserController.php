<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List all freelancers with filters and pagination.
     */
    public function index(Request $request)
    {
        $query = User::whereIn('type', ['freelancer', 'both'])
            ->where('status', 'active')
            ->where('professional_status', 'approved');

        // Apply filters
        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('bio', 'like', '%' . $request->search . '%');
            });
        }

        // Add stats
        $query->withCount(['receivedReviews as total_reviews'])
              ->withAvg('receivedReviews as average_rating', 'rating')
              ->withCount(['freelancerContracts as completed_contracts' => function($q) {
                  $q->where('status', 'completed');
              }]);

        // Filter by minimum rating
        if ($request->has('min_rating') && $request->min_rating) {
            $query->having('average_rating', '>=', $request->min_rating);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'average_rating');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'rating') {
            $query->orderBy('average_rating', $sortOrder);
        } elseif ($sortBy === 'completed_contracts') {
            $query->orderBy('completed_contracts', $sortOrder);
        } elseif ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortOrder);
        } else {
            $query->orderBy('average_rating', $sortOrder);
        }

        // Secondary sort by total reviews
        $query->orderBy('total_reviews', 'desc');

        // Pagination
        $perPage = $request->get('per_page', 20);
        $freelancers = $query->paginate($perPage);

        // Round average rating to 1 decimal
        $freelancers->getCollection()->transform(function($freelancer) {
            if ($freelancer->average_rating) {
                $freelancer->average_rating = round($freelancer->average_rating, 1);
            }
            // Add slug to response
            $freelancer->slug = $freelancer->slug;
            return $freelancer;
        });

        return response()->json([
            'status' => 'success',
            'data' => $freelancers
        ]);
    }

    /**
     * Show freelancer profile by slug or ID.
     */
    public function show($identifier)
    {
        // Check if identifier is numeric (ID) or string (slug)
        if (is_numeric($identifier)) {
            $user = User::whereIn('type', ['freelancer', 'both'])
                ->where('status', 'active')
                ->where('professional_status', 'approved')
                ->findOrFail($identifier);
        } else {
            $user = User::whereIn('type', ['freelancer', 'both'])
                ->where('status', 'active')
                ->where('professional_status', 'approved')
                ->where('slug', $identifier)
                ->firstOrFail();
        }

        // Load related data
        $user->load([
            'receivedReviews' => function($query) {
                $query->with(['reviewer', 'contract.task'])
                      ->latest()
                      ->limit(10);
            }
        ]);

        // Calculate stats
        $user->total_reviews = $user->receivedReviews()->count();
        $user->average_rating = round($user->receivedReviews()->avg('rating'), 1);
        $user->completed_contracts = $user->freelancerContracts()
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Get top freelancers with ratings.
     */
    public function topFreelancers(Request $request)
    {
        $limit = $request->get('limit', 6);

        $freelancers = User::whereIn('type', ['freelancer', 'both'])
            ->where('status', 'active')
            ->where('professional_status', 'approved')
            ->withCount(['receivedReviews as total_reviews'])
            ->withAvg('receivedReviews as average_rating', 'rating')
            ->withCount(['freelancerContracts as completed_contracts' => function($query) {
                $query->where('status', 'completed');
            }])
            ->having('total_reviews', '>', 0)
            ->orderBy('average_rating', 'desc')
            ->orderBy('total_reviews', 'desc')
            ->limit($limit)
            ->get(['id', 'name', 'email', 'avatar', 'bio', 'location']);

        // Round average rating to 1 decimal
        $freelancers->each(function($freelancer) {
            if ($freelancer->average_rating) {
                $freelancer->average_rating = round($freelancer->average_rating, 1);
            }
        });

        return response()->json([
            'status' => 'success',
            'data' => $freelancers
        ]);
    }

    /**
     * List all clients with filters and pagination.
     */
    public function indexClients(Request $request)
    {
        $query = User::whereIn('type', ['client', 'both'])
            ->where('status', 'active');

        // Apply filters
        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('bio', 'like', '%' . $request->search . '%');
            });
        }

        // Add stats
        $query->withCount(['writtenReviews as total_reviews'])
              ->withCount(['postedTasks as total_tasks'])
              ->withCount(['clientContracts as total_contracts']);

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'total_tasks') {
            $query->orderBy('total_tasks', $sortOrder);
        } elseif ($sortBy === 'total_contracts') {
            $query->orderBy('total_contracts', $sortOrder);
        } elseif ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortOrder);
        } else {
            $query->orderBy('created_at', $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 20);
        $clients = $query->paginate($perPage);

        // Add slug to response
        $clients->getCollection()->transform(function($client) {
            $client->slug = $client->slug;
            return $client;
        });

        return response()->json([
            'status' => 'success',
            'data' => $clients
        ]);
    }

    /**
     * Show client profile by slug or ID.
     */
    public function showClient($identifier)
    {
        // Check if identifier is numeric (ID) or string (slug)
        if (is_numeric($identifier)) {
            $user = User::whereIn('type', ['client', 'both'])
                ->where('status', 'active')
                ->findOrFail($identifier);
        } else {
            $user = User::whereIn('type', ['client', 'both'])
                ->where('status', 'active')
                ->where('slug', $identifier)
                ->firstOrFail();
        }

        // Load related data
        $user->load([
            'writtenReviews' => function($query) {
                $query->with(['reviewed', 'contract.task'])
                      ->latest()
                      ->limit(10);
            },
            'postedTasks' => function($query) {
                $query->where('status', 'open')
                      ->latest()
                      ->limit(5);
            }
        ]);

        // Calculate stats
        $user->total_reviews_written = $user->writtenReviews()->count();
        $user->total_tasks = $user->postedTasks()->count();
        $user->total_contracts = $user->clientContracts()->count();
        $user->completed_contracts = $user->clientContracts()
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
