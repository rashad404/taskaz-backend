<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    /**
     * Get all professional applications
     */
    public function index(Request $request)
    {
        $query = User::whereNotNull('professional_status');

        // Filter by status
        if ($request->has('status')) {
            $query->where('professional_status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $professionals = $query->orderBy('professional_application_date', 'desc')
                              ->paginate(20);

        return response()->json($professionals);
    }

    /**
     * Get a single professional application
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Approve a professional application
     */
    public function approve($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($user->professional_status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only pending applications can be approved'
            ], 400);
        }

        $user->update([
            'professional_status' => 'approved',
            'professional_approved_at' => now(),
            'professional_rejected_reason' => null,
        ]);

        // TODO: Send notification email to user

        return response()->json([
            'status' => 'success',
            'message' => 'Professional application approved',
            'data' => $user
        ]);
    }

    /**
     * Reject a professional application
     */
    public function reject($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($user->professional_status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only pending applications can be rejected'
            ], 400);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $user->update([
            'professional_status' => 'rejected',
            'professional_approved_at' => null,
            'professional_rejected_reason' => $validated['reason'],
        ]);

        // TODO: Send notification email to user

        return response()->json([
            'status' => 'success',
            'message' => 'Professional application rejected',
            'data' => $user
        ]);
    }

    /**
     * Revoke professional status
     */
    public function revoke($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($user->professional_status !== 'approved') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only approved professionals can be revoked'
            ], 400);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $user->update([
            'professional_status' => 'rejected',
            'professional_approved_at' => null,
            'professional_rejected_reason' => $validated['reason'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Professional status revoked',
            'data' => $user
        ]);
    }
}
