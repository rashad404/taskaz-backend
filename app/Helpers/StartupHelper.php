<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StartupHelper
{
    /**
     * Get all startups from the JSON configuration file
     * Cached for 24 hours for performance
     *
     * @return array
     */
    public static function getStartups(): array
    {
        return Cache::remember('startups_list', 60 * 60 * 24, function () {
            $jsonPath = config_path('startups.json');

            if (!file_exists($jsonPath)) {
                Log::warning('Startups JSON file not found at: ' . $jsonPath);
                return [];
            }

            $jsonContent = file_get_contents($jsonPath);
            $startups = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to parse startups JSON: ' . json_last_error_msg());
                return [];
            }

            return $startups ?? [];
        });
    }

    /**
     * Get limited number of startups
     *
     * @param int $limit
     * @return array
     */
    public static function getStartupsLimited(int $limit): array
    {
        $startups = self::getStartups();
        return array_slice($startups, 0, $limit);
    }

    /**
     * Clear the startups cache
     *
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget('startups_list');
    }

    /**
     * Get a specific startup by name
     *
     * @param string $name
     * @return array|null
     */
    public static function getStartupByName(string $name): ?array
    {
        $startups = self::getStartups();

        foreach ($startups as $startup) {
            if (strtolower($startup['name']) === strtolower($name)) {
                return $startup;
            }
        }

        return null;
    }
}
