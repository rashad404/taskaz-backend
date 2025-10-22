<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Get all cities
     */
    public function index()
    {
        $cities = City::orderBy('sort_order')
            ->orderBy('name_az')
            ->get(['id', 'name_az', 'name_en', 'name_ru', 'has_neighborhoods', 'sort_order']);

        return response()->json([
            'status' => 'success',
            'data' => $cities
        ]);
    }

    /**
     * Get districts for a specific city
     */
    public function districts($id)
    {
        $city = City::with(['districts' => function ($query) {
            $query->orderBy('sort_order')
                ->orderBy('name_az')
                ->select('id', 'city_id', 'name_az', 'name_en', 'name_ru', 'sort_order');
        }])->find($id);

        if (!$city) {
            return response()->json([
                'status' => 'error',
                'message' => 'City not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $city->districts
        ]);
    }

    /**
     * Get metro stations for a specific city
     */
    public function metroStations($id)
    {
        $city = City::with(['metroStations' => function ($query) {
            $query->orderBy('sort_order')
                ->orderBy('name_az')
                ->select('id', 'city_id', 'name_az', 'name_en', 'name_ru', 'sort_order');
        }])->find($id);

        if (!$city) {
            return response()->json([
                'status' => 'error',
                'message' => 'City not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $city->metroStations
        ]);
    }
}
