<?php

namespace App\Http\Controllers\Api;

use App\Helpers\StartupHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class StartupController extends Controller
{
    /**
     * Get all startups for cross-promotion
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $startups = StartupHelper::getStartups();

            return response()->json([
                'success' => true,
                'data' => $startups,
                'count' => count($startups)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch startups',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get limited number of startups
     *
     * @param int $limit
     * @return JsonResponse
     */
    public function limited(int $limit = 3): JsonResponse
    {
        try {
            $startups = StartupHelper::getStartupsLimited($limit);

            return response()->json([
                'success' => true,
                'data' => $startups,
                'count' => count($startups)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch startups',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear startups cache
     *
     * @return JsonResponse
     */
    public function clearCache(): JsonResponse
    {
        try {
            StartupHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Startups cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
