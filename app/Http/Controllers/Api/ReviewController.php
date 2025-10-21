<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Create a review for a completed contract.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $contract = Contract::findOrFail($validated['contract_id']);

        // Check if contract is completed
        if ($contract->status !== 'completed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Can only review completed contracts'
            ], 400);
        }

        $user = Auth::user();

        // Check if user is part of this contract
        if ($contract->client_id !== $user->id && $contract->freelancer_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if user already reviewed this contract
        $existingReview = Review::where('contract_id', $validated['contract_id'])
            ->where('reviewer_id', $user->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already reviewed this contract'
            ], 400);
        }

        // Determine reviewer and reviewed user
        if ($contract->client_id === $user->id) {
            // Client reviewing freelancer
            $validated['reviewer_id'] = $user->id;
            $validated['reviewed_id'] = $contract->freelancer_id;
            $validated['type'] = 'client_to_freelancer';
        } else {
            // Freelancer reviewing client
            $validated['reviewer_id'] = $user->id;
            $validated['reviewed_id'] = $contract->client_id;
            $validated['type'] = 'freelancer_to_client';
        }

        $review = Review::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully',
            'data' => $review->load(['reviewer', 'reviewed', 'contract'])
        ], 201);
    }

    /**
     * Get reviews for a specific user.
     */
    public function userReviews($userId, Request $request)
    {
        $reviews = Review::where('reviewed_id', $userId)
            ->with(['reviewer', 'contract'])
            ->latest()
            ->paginate($request->get('per_page', 20));

        $averageRating = Review::where('reviewed_id', $userId)->avg('rating');

        return response()->json([
            'status' => 'success',
            'data' => [
                'reviews' => $reviews,
                'average_rating' => round($averageRating, 2),
                'total_reviews' => Review::where('reviewed_id', $userId)->count(),
            ]
        ]);
    }
}
