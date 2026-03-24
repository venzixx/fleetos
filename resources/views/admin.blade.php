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
        max-width: 1100px;
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

    .page-title span { color: var(--app-accent); }

    .live-badge,
    .panel-kicker,
    .th {
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

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .stat-card,
    .ops-panel,
    .table-card {
        border: 1px solid var(--app-border);
        border-radius: 20px;
        background: var(--app-surface);
        box-shadow: var(--app-shadow);
        overflow: hidden;
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
        grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
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

    .status-badge {
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

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
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
        min-height: 34px;
        padding: 5px 30px 5px 10px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        cursor: pointer;
        outline: none;
        background: var(--app-surface-strong);
    }

    .role-select.admin-select {
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
        background: rgba(245, 158, 11, 0.1);
    }

    .role-select.driver-select {
        color: color-mix(in srgb, var(--app-accent) 80%, var(--app-text) 20%);
        border: 1px solid var(--app-accent-border);
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
        align-items: center;
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
        margin-top: 7px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .uc-actions {
        flex-shrink: 0;
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

    @media (max-width: 640px) {
        .admin-wrap {
            padding: 16px 12px 60px;
        }

        .stats-row {
            grid-template-columns: 1fr 1fr;
        }

        .table-view {
            display: none;
        }

        .card-list {
            display: block;
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
    $users = \App\Models\User::all();
    $online = $users->where('status', 'online')->count();
    $offline = $users->where('status', 'offline')->count();
    $drivers = $users->where('role', 'driver')->count();
    $admins = $users->where('role', 'admin')->count();
@endphp

<div class="admin-wrap">
    <div class="admin-shell">
        <div class="page-header">
            <div class="page-title">Admin <span>Dashboard</span></div>
            <div class="live-badge"><span class="live-dot"></span> Team overview</div>
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
                <div class="stat-label">Offline</div>
                <div class="stat-value red">{{ $offline }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Admins</div>
                <div class="stat-value">{{ $admins }}</div>
            </div>
        </div>

        <section class="ops-panel">
            <div class="ops-copy">
                <div class="panel-kicker">Operations</div>
                <h2 class="panel-title">User management stays here. Live map lives on the dashboard.</h2>
                <p class="panel-copy">
                    The admin area is now focused on roles, status monitoring, and account oversight. Driver map tracking has been moved out of this page so the management view stays cleaner and easier to maintain.
                </p>
                <a href="{{ route('dashboard') }}#driverMapPanel" class="panel-link">Open Driver Map</a>
            </div>

            <div class="ops-meta">
                <div class="ops-meta-grid">
                    <div class="meta-card">
                        <div class="panel-kicker">Drivers</div>
                        <div class="meta-card-value">{{ $drivers }} active accounts</div>
                    </div>
                    <div class="meta-card">
                        <div class="panel-kicker">Online Drivers</div>
                        <div class="meta-card-value">{{ $users->where('role', 'driver')->where('status', 'online')->count() }} currently tracking</div>
                    </div>
                    <div class="meta-card">
                        <div class="panel-kicker">You</div>
                        <div class="meta-card-value">{{ $currentUser->name }}</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="table-card">
            <div class="table-card-header">
                <div>
                    <div class="table-card-title">All Users</div>
                    <div class="table-card-sub">Manage roles and monitor driver status</div>
                </div>
            </div>

            <div class="table-view">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
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
                                    @if(auth()->id() !== $user->id)
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
                @foreach($users as $user)
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
                            </div>
                        </div>
                        <div class="uc-actions">
                            @if(auth()->id() !== $user->id)
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

</x-app-layout>
