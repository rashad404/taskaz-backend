<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Contract;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Get platform statistics
     */
    public function index()
    {
        // Total users (clients + professionals, excluding admins)
        $totalUsers = User::whereIn('type', ['client', 'professional'])
            ->where('status', 'active')
            ->count();

        // Active tasks (open status)
        $activeTasks = Task::where('status', 'open')->count();

        // Completed contracts
        $completedContracts = Contract::where('status', 'completed')->count();

        // Average rating (from reviews)
        $averageRating = Review::avg('rating') ?? 0;

        // Round rating to 1 decimal place
        $averageRating = round($averageRating, 1);

        return response()->json([
            'status' => 'success',
            'data' => [
                'totalUsers' => $totalUsers,
                'activeTasks' => $activeTasks,
                'completedContracts' => $completedContracts,
                'averageRating' => $averageRating,
            ]
        ]);
    }
}
