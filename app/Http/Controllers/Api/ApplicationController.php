<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Task;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Store a newly created application.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'proposed_amount' => 'required|numeric|min:0',
            'message' => 'required|string',
            'estimated_days' => 'nullable|integer|min:1',
        ]);

        $task = Task::findOrFail($validated['task_id']);

        // Check if task is still open
        if ($task->status !== 'open') {
            return response()->json([
                'status' => 'error',
                'message' => 'This task is no longer accepting applications'
            ], 400);
        }

        // Check if user already applied
        $existingApplication = Application::where('task_id', $validated['task_id'])
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already applied to this task'
            ], 400);
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $application = Application::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Application submitted successfully',
            'data' => $application->load(['task', 'professional'])
        ], 201);
    }

    /**
     * Get applications for authenticated user (as professional).
     */
    public function myApplications(Request $request)
    {
        $applications = Application::where('user_id', Auth::id())
            ->with(['task', 'task.client'])
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $applications
        ]);
    }

    /**
     * Accept an application and create a contract.
     */
    public function accept($id)
    {
        $application = Application::with('task')->findOrFail($id);

        // Check if authenticated user is the task owner
        if ($application->task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if application is still pending
        if ($application->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'This application has already been processed'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Update application status
            $application->update(['status' => 'accepted']);

            // Create contract
            $contract = Contract::create([
                'task_id' => $application->task_id,
                'application_id' => $application->id,
                'client_id' => $application->task->user_id,
                'professional_id' => $application->user_id,
                'final_amount' => $application->proposed_amount,
                'status' => 'active',
                'started_at' => now(),
            ]);

            // Update task status
            $application->task->update(['status' => 'assigned']);

            // Reject all other pending applications for this task
            Application::where('task_id', $application->task_id)
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Application accepted and contract created',
                'data' => $contract->load(['task', 'professional', 'client'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to accept application'
            ], 500);
        }
    }

    /**
     * Reject an application.
     */
    public function reject($id)
    {
        $application = Application::with('task')->findOrFail($id);

        // Check if authenticated user is the task owner
        if ($application->task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if application is still pending
        if ($application->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'This application has already been processed'
            ], 400);
        }

        $application->update(['status' => 'rejected']);

        return response()->json([
            'status' => 'success',
            'message' => 'Application rejected'
        ]);
    }
}
