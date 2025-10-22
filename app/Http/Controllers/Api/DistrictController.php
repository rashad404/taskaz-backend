<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Get settlements for a specific district
     */
    public function settlements($id)
    {
        $district = District::with(['settlements' => function ($query) {
            $query->orderBy('sort_order')
                ->orderBy('name_az')
                ->select('id', 'district_id', 'name_az', 'name_en', 'name_ru', 'sort_order');
        }])->find($id);

        if (!$district) {
            return response()->json([
                'status' => 'error',
                'message' => 'District not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $district->settlements
        ]);
    }
}
