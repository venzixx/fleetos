<?php

use App\Http\Controllers\FleetController;
use App\Http\Controllers\ProfileController;
use App\Services\TraccarService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', function () {
    return view('welcome');
});

Route::get('/offline', function () {
    return response()->file(public_path('offline.html'));
});

Route::get('/sw.js', function () {
    return response()->file(public_path('sw.js'), [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
});

// Authenticated
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Maps page
    Route::get('/maps', function () {
        return view('maps');
    })->name('maps');

    // Fleet / Traccar API endpoints used by the live map
    Route::get('/api/fleet/positions', [FleetController::class, 'positions'])->name('fleet.positions');
    Route::get('/api/fleet/status', [FleetController::class, 'status'])->name('fleet.status');

    // Driver status
    Route::post('/update-status', function (Request $request) {
        $user = Auth::user();
        $user->status = $request->status;
        $user->save();

        if ($request->status === 'online') {
            $admins = \App\Models\User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\DriverStatusNotification(
                    'Tracking Enabled',
                    $user->name . ' enabled tracking.',
                    '/admin'
                ));
            }
        } elseif ($request->status === 'offline') {
            $admins = \App\Models\User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\DriverStatusNotification(
                    'Tracking Disabled',
                    $user->name . ' disabled tracking.',
                    '/admin'
                ));
            }
        }

        return response()->json(['success' => true]);
    });

    Route::post('/location/update', function (Request $request) {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = Auth::user();
        $user->latitude = $validated['latitude'];
        $user->longitude = $validated['longitude'];
        $user->location_accuracy = $validated['accuracy'] ?? null;
        $user->location_updated_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'location' => [
                'latitude' => (float) $user->latitude,
                'longitude' => (float) $user->longitude,
                'accuracy' => $user->location_accuracy !== null ? (float) $user->location_accuracy : null,
                'updated_at' => optional($user->location_updated_at)->toIso8601String(),
            ],
        ]);
    })->name('location.update');

    // Admin panel
    Route::get('/admin', function () {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403);
        }

        $users = \App\Models\User::all();
        $traccarDevices = collect(app(TraccarService::class)->getDevices())
            ->sortBy(fn (array $device) => strtolower($device['name'] ?? ''))
            ->values();

        return view('admin', compact('users', 'traccarDevices'));
    });

    // Update role
    Route::post('/update-role/{id}', function (Request $request, $id) {
        $currentUser = Auth::user();
        if ($currentUser->role !== 'admin') {
            abort(403);
        }

        $user = \App\Models\User::findOrFail($id);
        if ($user->id === $currentUser->id) {
            return back();
        }

        $user->role = $request->role;
        $user->save();

        return back();
    });

    // Update Traccar device mapping
    Route::post('/users/{id}/traccar-device', function (Request $request, $id) {
        $currentUser = Auth::user();
        if ($currentUser->role !== 'admin') {
            abort(403);
        }

        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'traccar_device_id' => [
                'nullable',
                'integer',
                'min:1',
                Rule::unique('users', 'traccar_device_id')->ignore($user->id),
            ],
        ], [
            'traccar_device_id.unique' => 'That Traccar device is already assigned to another user.',
        ]);

        $user->traccar_device_id = $validated['traccar_device_id'] ?? null;
        $user->save();

        return back()->with('status', $user->traccar_device_id
            ? "Traccar device linked for {$user->name}."
            : "Traccar device cleared for {$user->name}.");
    })->name('users.traccar-device.update');

    // Push subscription
    Route::post('/push/subscribe', function (Request $request) {
        $user = Auth::user();

        \Log::info('Push subscribe called', [
            'user' => $user->id,
            'endpoint' => $request->endpoint,
            'keys' => $request->keys,
        ]);

        $user->updatePushSubscription(
            $request->endpoint,
            $request->keys['p256dh'] ?? null,
            $request->keys['auth'] ?? null,
        );

        return response()->json(['success' => true]);
    });

    // Test push (admin only)
    Route::get('/push/test', function () {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403);
        }

        $user->notify(new \App\Notifications\DriverStatusNotification(
            'FleetOS Test',
            'This is a test push notification!',
            '/admin'
        ));

        return response()->json(['success' => true, 'message' => 'Notification sent!']);
    });
});

require __DIR__ . '/auth.php';
