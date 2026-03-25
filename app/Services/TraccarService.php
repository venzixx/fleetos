<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TraccarService
{
    protected string $baseUrl;
    protected string $user;
    protected string $password;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('traccar.url'), '/');
        $this->user = (string) config('traccar.user');
        $this->password = (string) config('traccar.password');
    }

    protected function client(): PendingRequest
    {
        return Http::withBasicAuth($this->user, $this->password)
            ->timeout(8)
            ->acceptJson();
    }

    public function getDevices(): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/api/devices");

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            Log::warning('[Traccar] getDevices failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (ConnectionException $exception) {
            Log::error('[Traccar] getDevices connection error: ' . $exception->getMessage());
        }

        return [];
    }

    public function getPositions(?int $deviceId = null): array
    {
        try {
            $params = $deviceId !== null ? ['deviceId' => $deviceId] : [];
            $response = $this->client()->get("{$this->baseUrl}/api/positions", $params);

            if ($response->successful()) {
                $positions = $response->json() ?? [];
                $keyed = [];

                foreach ($positions as $position) {
                    $positionDeviceId = $position['deviceId'] ?? null;

                    if ($positionDeviceId === null) {
                        continue;
                    }

                    $keyed[(int) $positionDeviceId] = $position;
                }

                return $keyed;
            }

            Log::warning('[Traccar] getPositions failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (ConnectionException $exception) {
            Log::error('[Traccar] getPositions connection error: ' . $exception->getMessage());
        }

        return [];
    }

    public function getDriversWithPositions(): array
    {
        $devices = $this->getDevices();

        if ($devices === []) {
            return [];
        }

        $positions = $this->getPositions();

        // Use uniqueId to match against traccar_device_id stored in users table
        $uniqueIds = array_values(array_filter(
            array_map(static fn (array $device): ?string => $device['uniqueId'] ?? null, $devices)
        ));

        $usersByUniqueId = User::query()
            ->whereIn('traccar_device_id', $uniqueIds)
            ->get()
            ->keyBy('traccar_device_id');

        $drivers = [];

        foreach ($devices as $device) {
            $deviceId = isset($device['id']) ? (int) $device['id'] : null;
            $uniqueId = $device['uniqueId'] ?? null;

            if ($deviceId === null) {
                continue;
            }

            $position = $positions[$deviceId] ?? null;
            $user = $uniqueId ? $usersByUniqueId->get($uniqueId) : null;

            $drivers[] = [
                'device_id'  => $deviceId,
                'unique_id'  => $uniqueId,
                'name'       => $user?->name ?? ($device['name'] ?? 'Unknown Driver'),
                'status'     => $device['status'] ?? 'offline',
                'latitude'   => $position ? (float) $position['latitude'] : null,
                'longitude'  => $position ? (float) $position['longitude'] : null,
                'speed'      => $position ? round((float) $position['speed'] * 1.852, 1) : null,
                'accuracy'   => isset($position['accuracy']) ? (float) $position['accuracy'] : null,
                'updated_at' => $position['fixTime'] ?? ($device['lastUpdate'] ?? null),
            ];
        }

        return $drivers;
    }

    public function isReachable(): bool
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/api/server");

            return $response->successful();
        } catch (ConnectionException) {
            return false;
        }
    }
}
