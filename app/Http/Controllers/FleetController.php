<?php

namespace App\Http\Controllers;

use App\Services\TraccarService;
use Illuminate\Http\JsonResponse;

class FleetController extends Controller
{
    public function __construct(protected TraccarService $traccar)
    {
    }

    public function positions(): JsonResponse
    {
        $drivers = $this->traccar->getDriversWithPositions();

        return response()->json([
            'success' => true,
            'drivers' => $drivers,
            'count' => count($drivers),
        ]);
    }

    public function status(): JsonResponse
    {
        $reachable = $this->traccar->isReachable();

        return response()->json([
            'traccar_online' => $reachable,
            'message' => $reachable
                ? 'Traccar server is reachable'
                : 'Traccar server is unreachable - check your TRACCAR_URL and credentials',
        ]);
    }
}
