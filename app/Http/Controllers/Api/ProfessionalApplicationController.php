<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\District;
use App\Models\Settlement;
use App\Models\MetroStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfessionalApplicationController extends Controller
{
    /**
     * Submit professional application.
     */
    public function apply(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending or approved application
        if ($user->professional_status === 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have a pending application'
            ], 400);
        }

        if ($user->professional_status === 'approved') {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already an approved professional'
            ], 400);
        }

        $validated = $request->validate([
            'bio' => 'required|string|min:50|max:1000',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'nullable|exists:districts,id',
            'settlement_id' => 'nullable|exists:settlements,id',
            'metro_station_id' => 'nullable|exists:metro_stations,id',
            'skills' => 'required|array|min:3|max:15',
            'skills.*' => 'string|max:50',
            'hourly_rate' => 'required|numeric|min:1|max:9999',
            'portfolio_items' => 'nullable|array|max:5',
            'portfolio_items.*.title' => 'required|string|max:200',
            'portfolio_items.*.description' => 'nullable|string|max:500',
            'portfolio_items.*.image_url' => 'nullable|url|max:500',
            'portfolio_items.*.project_url' => 'nullable|url|max:500',
        ]);

        // Build location string from IDs
        $location = $this->buildLocationString(
            $validated['city_id'],
            $validated['district_id'] ?? null,
            $validated['settlement_id'] ?? null,
            $validated['metro_station_id'] ?? null
        );

        // Update user with professional details
        $user->update([
            'bio' => $validated['bio'],
            'location' => $location,
            'city_id' => $validated['city_id'],
            'district_id' => $validated['district_id'] ?? null,
            'settlement_id' => $validated['settlement_id'] ?? null,
            'metro_station_id' => $validated['metro_station_id'] ?? null,
            'skills' => $validated['skills'],
            'hourly_rate' => $validated['hourly_rate'],
            'portfolio_items' => $validated['portfolio_items'] ?? null,
            'professional_status' => 'pending',
            'professional_application_date' => now(),
            'professional_approved_at' => null,
            'professional_rejected_reason' => null,
            'type' => in_array($user->type, ['freelancer', 'both']) ? $user->type : 'both',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Your professional application has been submitted successfully. You will be notified once it is reviewed.',
            'data' => [
                'professional_status' => $user->professional_status,
                'application_date' => $user->professional_application_date,
            ]
        ], 201);
    }

    /**
     * Get current user's professional application status.
     */
    public function status()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'data' => [
                'professional_status' => $user->professional_status,
                'application_date' => $user->professional_application_date,
                'approved_at' => $user->professional_approved_at,
                'rejected_reason' => $user->professional_rejected_reason,
                'can_apply' => is_null($user->professional_status) || $user->professional_status === 'rejected',
                'can_update' => $user->professional_status === 'approved',
            ]
        ]);
    }

    /**
     * Update professional profile (only for approved professionals).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->professional_status !== 'approved') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only approved professionals can update their profile'
            ], 403);
        }

        $validated = $request->validate([
            'bio' => 'sometimes|string|min:50|max:1000',
            'location' => 'sometimes|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'district_id' => 'nullable|exists:districts,id',
            'settlement_id' => 'nullable|exists:settlements,id',
            'metro_station_id' => 'nullable|exists:metro_stations,id',
            'skills' => 'sometimes|array|min:3|max:15',
            'skills.*' => 'string|max:50',
            'hourly_rate' => 'sometimes|numeric|min:1|max:9999',
            'portfolio_items' => 'nullable|array|max:5',
            'portfolio_items.*.title' => 'required|string|max:200',
            'portfolio_items.*.description' => 'nullable|string|max:500',
            'portfolio_items.*.image_url' => 'nullable|url|max:500',
            'portfolio_items.*.project_url' => 'nullable|url|max:500',
        ]);

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Professional profile updated successfully',
            'data' => $user->only([
                'bio',
                'location',
                'city_id',
                'district_id',
                'settlement_id',
                'metro_station_id',
                'skills',
                'hourly_rate',
                'portfolio_items'
            ])
        ]);
    }

    /**
     * Reapply after rejection.
     */
    public function reapply(Request $request)
    {
        $user = Auth::user();

        if ($user->professional_status !== 'rejected') {
            return response()->json([
                'status' => 'error',
                'message' => 'You can only reapply after rejection'
            ], 400);
        }

        // Same validation as apply
        return $this->apply($request);
    }

    /**
     * Build location string from location IDs.
     */
    private function buildLocationString($cityId, $districtId = null, $settlementId = null, $metroStationId = null)
    {
        $parts = [];

        if ($cityId) {
            $city = City::find($cityId);
            if ($city) {
                $parts[] = $city->name_az;
            }
        }

        if ($districtId) {
            $district = District::find($districtId);
            if ($district) {
                $parts[] = $district->name_az;
            }
        }

        if ($settlementId) {
            $settlement = Settlement::find($settlementId);
            if ($settlement) {
                $parts[] = $settlement->name_az;
            }
        }

        if ($metroStationId) {
            $metro = MetroStation::find($metroStationId);
            if ($metro) {
                $parts[] = $metro->name_az . ' (metro)';
            }
        }

        return implode(', ', $parts);
    }
}
