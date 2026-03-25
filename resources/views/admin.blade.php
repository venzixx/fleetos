<x-app-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--app-bg);
        -webkit-tap-highlight-color: transparent;
        -webkit-text-size-adjust: 100%;
    }

    .admin-wrap {
        min-height: calc(100vh - 72px);
        min-height: calc(100dvh - 72px);
        background:
            radial-gradient(circle at top, color-mix(in srgb, var(--app-accent) 12%, transparent), transparent 32%),
            linear-gradient(180deg, var(--app-bg) 0%, var(--app-bg-soft) 100%);
        padding: 24px 16px 60px;
        padding-bottom: max(60px, env(safe-area-inset-bottom, 60px));
        color: var(--app-text);
    }

    .admin-shell {
        max-width: 1160px;
        margin: 0 auto;
        display: grid;
        gap: 20px;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-title {
        font-size: clamp(1.45rem, 3vw, 1.95rem);
        font-weight: 700;
        letter-spacing: -0.035em;
        color: var(--app-text);
    }

    .page-title span {
        color: var(--app-accent);
    }

    .live-badge,
    .panel-kicker,
    .th,
    .device-helper,
    .banner-copy {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.68rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .live-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        border: 1px solid var(--app-border);
        background: var(--app-surface);
        color: var(--app-text-muted);
    }

    .live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--app-accent);
        box-shadow: 0 0 0 0 color-mix(in srgb, var(--app-accent) 60%, transparent);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; box-shadow: 0 0 0 0 color-mix(in srgb, var(--app-accent) 60%, transparent); }
        50% { opacity: 0.72; box-shadow: 0 0 0 6px transparent; }
    }

    .flash-banner,
    .info-banner,
    .stat-card,
    .ops-panel,
    .table-card {
        border: 1px solid var(--app-border);
        border-radius: 20px;
        background: var(--app-surface);
        box-shadow: var(--app-shadow);
    }

    .flash-banner,
    .info-banner {
        padding: 14px 18px;
    }

    .flash-banner {
        color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
        background: var(--app-accent-soft);
        border-color: var(--app-accent-border);
        font-weight: 700;
    }

    .flash-banner.error {
        color: var(--app-danger-text);
        background: var(--app-danger-soft);
        border-color: color-mix(in srgb, var(--app-danger-text) 20%, var(--app-border));
    }

    .info-banner {
        display: grid;
        gap: 6px;
    }

    .banner-title {
        font-size: 0.96rem;
        font-weight: 700;
        color: var(--app-text);
    }

    .banner-copy {
        color: var(--app-text-muted);
        line-height: 1.7;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .stat-card {
        padding: 18px 20px;
    }

    .stat-label {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--app-text-muted);
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 1.65rem;
        font-weight: 700;
        letter-spacing: -0.03em;
        color: var(--app-text);
        line-height: 1;
    }

    .stat-value.green { color: var(--app-accent); }
    .stat-value.red { color: var(--app-danger-text); }

    .ops-panel {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(300px, 0.8fr);
        overflow: hidden;
    }

    .ops-copy,
    .ops-meta {
        padding: 22px 24px;
    }

    .ops-copy {
        border-right: 1px solid var(--app-border);
    }

    .panel-kicker {
        color: var(--app-text-muted);
    }

    .panel-title {
        margin-top: 10px;
        font-size: clamp(1.35rem, 2.8vw, 2rem);
        font-weight: 700;
        letter-spacing: -0.03em;
        color: var(--app-text);
    }

    .panel-copy {
        margin-top: 14px;
        max-width: 62ch;
        color: var(--app-text-soft);
        font-size: 0.96rem;
        line-height: 1.75;
    }

    .panel-link {
        margin-top: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 18px;
        border-radius: 14px;
        border: 1px solid var(--app-accent-border);
        background: var(--app-accent-soft);
        color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
        text-decoration: none;
        font-weight: 700;
    }

    .ops-meta-grid {
        display: grid;
        gap: 12px;
    }

    .meta-card {
        border-radius: 16px;
        border: 1px solid var(--app-border);
        background: var(--app-surface-strong);
        padding: 16px;
    }

    .meta-card-value {
        margin-top: 8px;
        font-size: 1.04rem;
        font-weight: 700;
        color: var(--app-text);
    }

    .table-card {
        overflow: hidden;
    }

    .table-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--app-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .table-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--app-text);
    }

    .table-card-sub {
        font-size: 0.85rem;
        color: var(--app-text-muted);
    }

    .table-view { display: block; }
    .card-list { display: none; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead tr {
        background: var(--app-bg);
        border-bottom: 1px solid var(--app-border);
    }

    th {
        padding: 12px 20px;
        text-align: left;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.65rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--app-text-muted);
    }

    tbody tr {
        border-bottom: 1px solid var(--app-border);
        transition: background 0.14s ease;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--app-surface-strong); }

    td {
        padding: 14px 20px;
        font-size: 0.88rem;
        color: var(--app-text-soft);
        vertical-align: middle;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar,
    .uc-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid var(--app-border);
        background: var(--app-surface-strong);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--app-text);
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-name,
    .uc-name {
        font-weight: 600;
        color: var(--app-text);
    }

    .email-cell,
    .uc-email {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.72rem;
        color: var(--app-text-muted);
    }

    .status-badge,
    .device-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge.online {
        background: var(--app-accent-soft);
        border: 1px solid var(--app-accent-border);
        color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
    }

    .status-badge.offline {
        background: var(--app-surface-strong);
        border: 1px solid var(--app-border);
        color: var(--app-text-muted);
    }

    .device-badge {
        background: color-mix(in srgb, var(--app-surface-strong) 92%, transparent);
        border: 1px solid var(--app-border);
        color: var(--app-text-soft);
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .device-form {
        display: grid;
        gap: 7px;
        min-width: 230px;
    }

    .device-field-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .device-input,
    .role-select {
        min-height: 36px;
        border-radius: 10px;
        border: 1px solid var(--app-border);
        background: var(--app-surface-strong);
        color: var(--app-text);
        font-family: 'Inter', sans-serif;
        outline: none;
    }

    .device-input {
        width: 100%;
        padding: 0 12px;
        font-size: 0.82rem;
    }

    .device-input::placeholder {
        color: var(--app-text-muted);
    }

    .device-save-btn {
        min-height: 36px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1px solid var(--app-accent-border);
        background: var(--app-accent-soft);
        color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .device-helper {
        color: var(--app-text-muted);
        line-height: 1.5;
    }

    .device-name {
        color: var(--app-text);
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: normal;
        text-transform: none;
    }

    .role-form { display: inline-block; }

    .role-select-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .role-select-wrap::after {
        content: '';
        pointer-events: none;
        position: absolute;
        right: 10px;
        width: 5px;
        height: 5px;
        border-right: 1.5px solid currentColor;
        border-bottom: 1.5px solid currentColor;
        transform: rotate(45deg) translateY(-3px);
        opacity: 0.5;
    }

    .role-select-wrap.admin-wrap::after { color: #f59e0b; }
    .role-select-wrap.driver-wrap::after { color: var(--app-accent); }

    .role-select {
        appearance: none;
        -webkit-appearance: none;
        padding: 5px 30px 5px 10px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        cursor: pointer;
    }

    .role-select.admin-select {
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.2);
        background: rgba(245, 158, 11, 0.1);
    }

    .role-select.driver-select {
        color: color-mix(in srgb, var(--app-accent) 80%, var(--app-text) 20%);
        border-color: var(--app-accent-border);
        background: var(--app-accent-soft);
    }

    .you-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px dashed var(--app-border);
        background: var(--app-surface-strong);
        color: var(--app-text-muted);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .user-card {
        padding: 14px 16px;
        border-bottom: 1px solid var(--app-border);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .user-card:last-child { border-bottom: none; }

    .uc-info {
        flex: 1;
        min-width: 0;
    }

    .uc-name {
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .uc-email {
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .uc-badges {
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .uc-actions {
        width: min(280px, 100%);
        display: grid;
        gap: 10px;
    }

    @media (max-width: 980px) {
        .stats-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 860px) {
        .ops-panel {
            grid-template-columns: 1fr;
        }

        .ops-copy {
            border-right: 0;
            border-bottom: 1px solid var(--app-border);
        }
    }

    @media (max-width: 760px) {
        .table-view {
            display: none;
        }

        .card-list {
            display: block;
        }

        .user-card {
            flex-wrap: wrap;
        }

        .uc-actions {
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .admin-wrap {
            padding: 16px 12px 60px;
        }

        .stats-row {
            grid-template-columns: 1fr 1fr;
        }

        .device-field-row {
            flex-direction: column;
            align-items: stretch;
        }
    }

    @media (max-width: 380px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $currentUser = auth()->user();
    $users = $users ?? \App\Models\User::all();
    $traccarDevices = collect($traccarDevices ?? []);
    $traccarDeviceMap = $traccarDevices->keyBy(fn (array $device) => (int) ($device['id'] ?? 0));
    $online = $users->where('status', 'online')->count();
    $offline = $users->where('status', 'offline')->count();
    $drivers = $users->where('role', 'driver')->count();
    $admins = $users->where('role', 'admin')->count();
    $mappedDrivers = $users->where('role', 'driver')->whereNotNull('traccar_device_id')->count();
    $unmappedDrivers = max($drivers - $mappedDrivers, 0);
@endphp

<div class="admin-wrap">
    <div class="admin-shell">
        <div class="page-header">
            <div class="page-title">Admin <span>Dashboard</span></div>
            <div class="live-badge"><span class="live-dot"></span> Team overview</div>
        </div>

        @if (session('status'))
            <div class="flash-banner">{{ session('status') }}</div>
        @endif

        @if ($errors->has('traccar_device_id'))
            <div class="flash-banner error">{{ $errors->first('traccar_device_id') }}</div>
        @endif

        <div class="info-banner">
            <div class="banner-title">Traccar device mapping</div>
            <div class="banner-copy">
                @if ($traccarDevices->isNotEmpty())
                    {{ $traccarDevices->count() }} Traccar device suggestions are loaded. Enter a device ID manually or use one from the Traccar list, then save it to link that user to live map data.
                @else
                    No Traccar device suggestions are loaded right now. You can still enter a numeric device ID manually and save it.
                @endif
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $users->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Online Now</div>
                <div class="stat-value green">{{ $online }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Linked Drivers</div>
                <div class="stat-value">{{ $mappedDrivers }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Traccar Devices</div>
                <div class="stat-value">{{ $traccarDevices->count() }}</div>
            </div>
        </div>

        <section class="ops-panel">
            <div class="ops-copy">
                <div class="panel-kicker">Operations</div>
                <h2 class="panel-title">Manage users here and link drivers to their Traccar devices.</h2>
                <p class="panel-copy">
                    Once a driver has a saved <code>traccar_device_id</code>, the live fleet map can match the Traccar GPS feed back to that account. Keep one Traccar device linked to one user so the map stays accurate.
                </p>
                <a href="{{ route('maps') }}" class="panel-link">Open Live Fleet Map</a>
            </div>

            <div class="ops-meta">
                <div class="ops-meta-grid">
                    <div class="meta-card">
                        <div class="panel-kicker">Drivers</div>
                        <div class="meta-card-value">{{ $drivers }} driver accounts</div>
                    </div>
                    <div class="meta-card">
                        <div class="panel-kicker">Unlinked Drivers</div>
                        <div class="meta-card-value">{{ $unmappedDrivers }} still need a device</div>
                    </div>
                    <div class="meta-card">
                        <div class="panel-kicker">Offline Users</div>
                        <div class="meta-card-value">{{ $offline }} currently offline</div>
                    </div>
                    <div class="meta-card">
                        <div class="panel-kicker">Admins</div>
                        <div class="meta-card-value">{{ $admins }} admin account{{ $admins !== 1 ? 's' : '' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <div class="table-card-title">All Users</div>
                    <div class="table-card-sub">Manage roles, monitor status, and assign Traccar device IDs</div>
                </div>
            </div>

            <div class="table-view">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Traccar Device</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @php
                                $linkedDevice = $user->traccar_device_id ? $traccarDeviceMap->get((int) $user->traccar_device_id) : null;
                                $inputValue = old('mapping_user_id') == $user->id
                                    ? old('traccar_device_id')
                                    : ($user->traccar_device_id ?? '');
                            @endphp
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <span class="user-name">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td><span class="email-cell">{{ $user->email }}</span></td>
                                <td>
                                    <span class="status-badge {{ $user->status === 'online' ? 'online' : 'offline' }}">
                                        <span class="status-dot"></span>
                                        {{ $user->status === 'online' ? 'Online' : 'Offline' }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('users.traccar-device.update', $user->id) }}" class="device-form">
                                        @csrf
                                        <input type="hidden" name="mapping_user_id" value="{{ $user->id }}">
                                        <div class="device-field-row">
                                            <input
                                                type="text"
                                                name="traccar_device_id"
                                                inputmode="numeric"
                                                pattern="[0-9]*"
                                                class="device-input"
                                                value="{{ $inputValue }}"
                                                placeholder="Enter device ID"
                                                {{ $traccarDevices->isNotEmpty() ? 'list=traccarDeviceOptions' : '' }}
                                            >
                                            <button type="submit" class="device-save-btn">Save</button>
                                        </div>
                                        <div class="device-helper">
                                            @if ($linkedDevice)
                                                Linked to <span class="device-name">{{ $linkedDevice['name'] ?? 'Unnamed device' }}</span> (#{{ $user->traccar_device_id }})
                                            @elseif ($user->traccar_device_id)
                                                Saved as #{{ $user->traccar_device_id }}. Device is not in the current Traccar suggestions.
                                            @elseif ($traccarDevices->isNotEmpty())
                                                Not linked yet.
                                            @else
                                                Enter a numeric Traccar device ID manually.
                                            @endif
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    @if (auth()->id() !== $user->id)
                                        <form method="POST" action="/update-role/{{ $user->id }}" class="role-form">
                                            @csrf
                                            <div class="role-select-wrap {{ $user->role === 'admin' ? 'admin-wrap' : 'driver-wrap' }}">
                                                <select name="role" onchange="this.form.submit()" class="role-select {{ $user->role === 'admin' ? 'admin-select' : 'driver-select' }}">
                                                    <option value="driver" {{ $user->role === 'driver' ? 'selected' : '' }}>Driver</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                        </form>
                                    @else
                                        <span class="you-chip">You</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-list">
                @foreach ($users as $user)
                    @php
                        $linkedDevice = $user->traccar_device_id ? $traccarDeviceMap->get((int) $user->traccar_device_id) : null;
                        $inputValue = old('mapping_user_id') == $user->id
                            ? old('traccar_device_id')
                            : ($user->traccar_device_id ?? '');
                    @endphp
                    <div class="user-card">
                        <div class="uc-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div class="uc-info">
                            <div class="uc-name">{{ $user->name }}</div>
                            <div class="uc-email">{{ $user->email }}</div>
                            <div class="uc-badges">
                                <span class="status-badge {{ $user->status === 'online' ? 'online' : 'offline' }}">
                                    <span class="status-dot"></span>
                                    {{ $user->status === 'online' ? 'Online' : 'Offline' }}
                                </span>
                                @if ($user->traccar_device_id)
                                    <span class="device-badge">
                                        Device #{{ $user->traccar_device_id }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="uc-actions">
                            <form method="POST" action="{{ route('users.traccar-device.update', $user->id) }}" class="device-form">
                                @csrf
                                <input type="hidden" name="mapping_user_id" value="{{ $user->id }}">
                                <div class="device-field-row">
                                    <input
                                        type="text"
                                        name="traccar_device_id"
                                        inputmode="numeric"
                                        pattern="[0-9]*"
                                        class="device-input"
                                        value="{{ $inputValue }}"
                                        placeholder="Enter device ID"
                                        {{ $traccarDevices->isNotEmpty() ? 'list=traccarDeviceOptions' : '' }}
                                    >
                                    <button type="submit" class="device-save-btn">Save</button>
                                </div>
                                <div class="device-helper">
                                    @if ($linkedDevice)
                                        Linked to <span class="device-name">{{ $linkedDevice['name'] ?? 'Unnamed device' }}</span> (#{{ $user->traccar_device_id }})
                                    @elseif ($user->traccar_device_id)
                                        Saved as #{{ $user->traccar_device_id }}. Device is not in the current Traccar suggestions.
                                    @elseif ($traccarDevices->isNotEmpty())
                                        Not linked yet.
                                    @else
                                        Enter a numeric Traccar device ID manually.
                                    @endif
                                </div>
                            </form>

                            @if (auth()->id() !== $user->id)
                                <form method="POST" action="/update-role/{{ $user->id }}" class="role-form">
                                    @csrf
                                    <div class="role-select-wrap {{ $user->role === 'admin' ? 'admin-wrap' : 'driver-wrap' }}">
                                        <select name="role" onchange="this.form.submit()" class="role-select {{ $user->role === 'admin' ? 'admin-select' : 'driver-select' }}">
                                            <option value="driver" {{ $user->role === 'driver' ? 'selected' : '' }}>Driver</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                </form>
                            @else
                                <span class="you-chip">You</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if ($traccarDevices->isNotEmpty())
    <datalist id="traccarDeviceOptions">
        @foreach ($traccarDevices as $device)
            @php
                $deviceId = $device['id'] ?? null;
                $deviceName = $device['name'] ?? 'Unnamed device';
            @endphp
            @if ($deviceId !== null)
                <option value="{{ $deviceId }}">{{ $deviceName }}</option>
            @endif
        @endforeach
    </datalist>
@endif

</x-app-layout>
