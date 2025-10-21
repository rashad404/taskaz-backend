<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Create a payment for a contract.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,bank_transfer,online',
            'notes' => 'nullable|string',
        ]);

        $contract = Contract::findOrFail($validated['contract_id']);

        // Check if user is the client of this contract
        if ($contract->client_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if contract is still active
        if ($contract->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Contract is not active'
            ], 400);
        }

        $validated['status'] = 'pending';
        $validated['client_confirmed'] = false;
        $validated['freelancer_confirmed'] = false;

        $payment = Payment::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment created successfully',
            'data' => $payment->load('contract')
        ], 201);
    }

    /**
     * Get payments for authenticated user's contracts.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $payments = Payment::whereHas('contract', function($q) use ($user) {
            $q->where('client_id', $user->id)
              ->orWhere('freelancer_id', $user->id);
        })
        ->with('contract')
        ->latest()
        ->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data' => $payments
        ]);
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $user = Auth::user();

        $payment = Payment::with('contract')
            ->whereHas('contract', function($q) use ($user) {
                $q->where('client_id', $user->id)
                  ->orWhere('freelancer_id', $user->id);
            })
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $payment
        ]);
    }

    /**
     * Client confirms payment sent.
     */
    public function confirmByClient($id)
    {
        $payment = Payment::with('contract')->findOrFail($id);

        // Check if user is the client
        if ($payment->contract->client_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if already confirmed
        if ($payment->client_confirmed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Already confirmed by client'
            ], 400);
        }

        $payment->confirmByClient();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment confirmed by client',
            'data' => $payment->fresh()
        ]);
    }

    /**
     * Freelancer confirms payment received.
     */
    public function confirmByFreelancer($id)
    {
        $payment = Payment::with('contract')->findOrFail($id);

        // Check if user is the freelancer
        if ($payment->contract->freelancer_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if already confirmed
        if ($payment->freelancer_confirmed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Already confirmed by freelancer'
            ], 400);
        }

        $payment->confirmByFreelancer();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment confirmed by freelancer',
            'data' => $payment->fresh()
        ]);
    }
}
