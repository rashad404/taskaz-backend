<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    /**
     * Get contracts for authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Contract::with(['task', 'client', 'professional', 'payments'])
            ->where(function($q) use ($user) {
                $q->where('client_id', $user->id)
                  ->orWhere('professional_id', $user->id);
            });

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $contracts = $query->latest()->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $contracts
        ]);
    }

    /**
     * Display the specified contract.
     */
    public function show($id)
    {
        $user = Auth::user();

        $contract = Contract::with(['task', 'client', 'professional', 'payments', 'reviews'])
            ->where(function($q) use ($user) {
                $q->where('client_id', $user->id)
                  ->orWhere('professional_id', $user->id);
            })
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $contract
        ]);
    }

    /**
     * Complete a contract (by professional).
     */
    public function complete(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        // Check if user is the professional
        if ($contract->professional_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if contract is active
        if ($contract->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Contract is not active'
            ], 400);
        }

        $validated = $request->validate([
            'completion_notes' => 'nullable|string',
        ]);

        $contract->update([
            'status' => 'completed',
            'completed_at' => now(),
            'completion_notes' => $validated['completion_notes'] ?? null,
        ]);

        // Update task status
        $contract->task->update(['status' => 'completed']);

        return response()->json([
            'status' => 'success',
            'message' => 'Contract marked as completed',
            'data' => $contract
        ]);
    }

    /**
     * Cancel a contract.
     */
    public function cancel(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        $user = Auth::user();

        // Check if user is part of this contract
        if ($contract->client_id !== $user->id && $contract->professional_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if contract is active
        if ($contract->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Contract is not active'
            ], 400);
        }

        $contract->update(['status' => 'cancelled']);

        // Update task status back to open
        $contract->task->update(['status' => 'open']);

        return response()->json([
            'status' => 'success',
            'message' => 'Contract cancelled',
            'data' => $contract
        ]);
    }
}
