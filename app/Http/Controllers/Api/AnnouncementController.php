<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    /**
     * Get announcement statuses for the authenticated user.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            // Define all possible announcement types
            $announcementTypes = [
                'professional_approval',
                'feature_announcement',
                'promotional_banner',
                'important_notice',
            ];

            $statuses = $user->getAnnouncementStatuses($announcementTypes);

            return response()->json([
                'status' => 'success',
                'data' => $statuses
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch announcement statuses: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch announcement statuses'
            ], 500);
        }
    }

    /**
     * Dismiss a specific announcement.
     */
    public function dismiss(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string|max:100'
            ]);

            $user = $request->user();
            $announcement = $user->dismissAnnouncement($validated['type']);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'announcement_type' => $announcement->announcement_type,
                    'dismissed_at' => $announcement->dismissed_at,
                ],
                'message' => 'Announcement dismissed successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to dismiss announcement: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to dismiss announcement'
            ], 500);
        }
    }

    /**
     * Mark announcement as seen.
     */
    public function markAsSeen(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string|max:100'
            ]);

            $user = $request->user();
            $announcement = $user->markAnnouncementAsSeen($validated['type']);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'announcement_type' => $announcement->announcement_type,
                    'seen_at' => $announcement->seen_at,
                ],
                'message' => 'Announcement marked as seen'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to mark announcement as seen: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to mark announcement as seen'
            ], 500);
        }
    }

    /**
     * Get active (non-dismissed) announcements.
     */
    public function active(Request $request)
    {
        try {
            $user = $request->user();
            $announcements = $user->getActiveAnnouncements();

            return response()->json([
                'status' => 'success',
                'data' => $announcements
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch active announcements: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch active announcements'
            ], 500);
        }
    }
}
