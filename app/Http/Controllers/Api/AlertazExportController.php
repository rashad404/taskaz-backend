<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AlertazExportController extends Controller
{
    /**
     * Export users data for Alert.az integration
     */
    public function users(): JsonResponse
    {
        $users = User::whereNotNull('phone')
            ->with(['city', 'postedTasks', 'applications'])
            ->get()
            ->map(function ($user) {
                return [
                    'phone' => $this->formatPhone($user->phone),
                    'attributes' => [
                        'name' => $user->name,
                        'registration_date' => $user->created_at->format('Y-m-d'),
                        'is_professional' => $user->isProfessional(),
                        'professional_status' => $user->professional_status,
                        'type' => $user->type,
                        'tasks_count' => $user->postedTasks->count(),
                        'applications_count' => $user->applications->count(),
                        'city' => $user->city?->name ?? null,
                    ],
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'schema' => $this->getSchema(),
                'users' => $users,
                'total' => $users->count(),
            ],
        ]);
    }

    /**
     * Get the schema definition for Alert.az
     */
    private function getSchema(): array
    {
        return [
            ['key' => 'name', 'type' => 'string', 'label' => 'Ad'],
            ['key' => 'registration_date', 'type' => 'date', 'label' => 'Qeydiyyat tarixi'],
            ['key' => 'is_professional', 'type' => 'boolean', 'label' => 'Professional'],
            ['key' => 'professional_status', 'type' => 'enum', 'label' => 'Professional status', 'options' => ['pending', 'approved', 'rejected', null]],
            ['key' => 'type', 'type' => 'enum', 'label' => 'İstifadəçi tipi', 'options' => ['client', 'professional', 'both']],
            ['key' => 'tasks_count', 'type' => 'integer', 'label' => 'Tapşırıqlar sayı'],
            ['key' => 'applications_count', 'type' => 'integer', 'label' => 'Müraciətlər sayı'],
            ['key' => 'city', 'type' => 'string', 'label' => 'Şəhər'],
        ];
    }

    /**
     * Format phone number to international format (994XXXXXXXXX)
     */
    private function formatPhone(string $phone): string
    {
        // Remove all non-digits
        $phone = preg_replace('/\D/', '', $phone);

        // Ensure it starts with 994
        if (!str_starts_with($phone, '994')) {
            $phone = '994' . ltrim($phone, '0');
        }

        return $phone;
    }
}
