<x-app-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');

    .driver-wrap,
    .driver-wrap * {
        box-sizing: border-box;
    }

    body { font-family: 'Inter', sans-serif; background: var(--app-bg); -webkit-tap-highlight-color: transparent; -webkit-text-size-adjust: 100%; }

    .driver-wrap {
        min-height: calc(100vh - 72px);
        min-height: calc(100dvh - 72px);
        background:
            radial-gradient(circle at top, color-mix(in srgb, var(--app-accent) 18%, transparent), transparent 32%),
            linear-gradient(180deg, var(--app-bg) 0%, var(--app-bg-soft) 100%);
        padding: 24px 16px 40px;
        padding-bottom: max(40px, env(safe-area-inset-bottom, 40px));
        color: var(--app-text);
    }

    .driver-shell {
        max-width: 980px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(320px, 390px);
        gap: 24px;
        align-items: stretch;
    }

    .hero-card, .control-card {
        border: 1px solid var(--app-border);
        border-radius: 24px;
        background: var(--app-surface);
        box-shadow: var(--app-shadow);
        overflow: hidden;
    }

    .hero-card { padding: 28px; display: flex; flex-direction: column; justify-content: space-between; }
    .hero-kicker, .meta-label, .card-sub, .status-label {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: var(--app-text-muted);
    }
    .hero-title { margin-top: 12px; font-size: clamp(2rem, 4.6vw, 3.5rem); line-height: 1.02; letter-spacing: -0.045em; font-weight: 700; color: var(--app-text); max-width: 10ch; }
    .hero-copy { margin-top: 18px; max-width: 54ch; font-size: 1rem; line-height: 1.75; color: var(--app-text-soft); }
    .hero-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-top: 28px; }
    .hero-stat { border-radius: 16px; border: 1px solid var(--app-border); background: var(--app-surface-strong); padding: 16px; }
    .hero-stat-value { margin-top: 8px; font-size: 1.06rem; font-weight: 700; color: var(--app-text); }

    .control-accent { height: 3px; background: var(--app-accent); transition: background 0.3s ease; }
    .control-accent.offline { background: var(--app-danger-text); }
    .control-body { padding: 26px 24px 24px; }
    .icon-ring {
        width: 78px; height: 78px; margin: 0 auto 22px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.74rem; font-family: 'IBM Plex Mono', monospace; text-transform: uppercase; letter-spacing: 0.14em;
        border: 1px solid var(--app-border); background: var(--app-bg); color: var(--app-text);
        transition: border-color 0.3s ease, background 0.3s ease, color 0.3s ease;
    }
    .icon-ring.online { background: var(--app-accent-soft); border-color: var(--app-accent-border); color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%); }
    .icon-ring.offline { background: var(--app-danger-soft); border-color: var(--app-danger-border); color: var(--app-danger-text); }
    .card-title { text-align: center; font-size: 1.35rem; font-weight: 700; letter-spacing: -0.03em; color: var(--app-text); margin-bottom: 8px; }
    .card-sub { text-align: center; margin-bottom: 24px; }
    .status-row {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        margin-bottom: 22px; padding: 14px 18px; border-radius: 14px;
        border: 1px solid var(--app-border); background: var(--app-bg);
    }
    .status-row.online { background: var(--app-accent-soft); border-color: var(--app-accent-border); }
    .status-row.offline { background: var(--app-danger-soft); border-color: var(--app-danger-border); }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .status-dot.online { background: var(--app-accent); }
    .status-dot.offline { background: var(--app-danger-text); }
    .status-value { font-weight: 700; font-size: 0.95rem; }
    .status-value.online { color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%); }
    .status-value.offline { color: var(--app-danger-text); }
    .btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .btn {
        min-height: 52px; padding: 14px 16px; border-radius: 14px; font-family: 'Inter', sans-serif;
        font-size: 0.82rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        border: 1px solid transparent; cursor: pointer; transition: opacity 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        display: flex; align-items: center; justify-content: center; touch-action: manipulation; text-decoration: none;
    }
    .btn:disabled { opacity: 0.45; cursor: not-allowed; }
    .btn-start { background: var(--app-text); color: var(--app-surface-strong); }
    .btn-stop { background: var(--app-surface-strong); border-color: var(--app-border); color: var(--app-text-soft); }
    .btn-notify {
        margin-top: 14px; width: 100%; min-height: 52px; padding: 14px 16px; border-radius: 14px;
        font-family: 'Inter', sans-serif; font-size: 0.82rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--app-border); background: var(--app-surface-strong); color: var(--app-text-soft);
    }
    .btn-notify.success { background: var(--app-accent-soft); color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%); border-color: var(--app-accent-border); cursor: default; }
    .btn-notify.error { background: var(--app-danger-soft); color: var(--app-danger-text); border-color: var(--app-danger-border); }
    .card-footer { padding: 14px 24px; border-top: 1px solid var(--app-border); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .footer-name { font-size: 0.88rem; font-weight: 600; color: var(--app-text-soft); }
    .footer-name span { color: var(--app-text); }
    .session-clock { font-family: 'IBM Plex Mono', monospace; font-size: 0.76rem; color: var(--app-text-muted); letter-spacing: 0.08em; }

    @media (max-width: 920px) {
        .driver-shell { grid-template-columns: 1fr; }
        .hero-title { max-width: none; }
    }

    @media (max-width: 480px) {
        .driver-wrap { padding: 16px 12px 36px; }
        .hero-card, .control-body { padding-left: 20px; padding-right: 20px; }
        .hero-grid { grid-template-columns: 1fr; }
        .btn-group { grid-template-columns: 1fr; }
        .card-footer { flex-direction: column; align-items: flex-start; }
    }
</style>

@php
    $currentStatus = auth()->user()->status ?? 'offline';
    $hasLocation = auth()->user()->latitude !== null && auth()->user()->longitude !== null;
@endphp

<div class="driver-wrap">
    <div class="driver-shell">
        <section class="hero-card">
            <div>
                <div class="hero-kicker">Driver workspace</div>
                <h1 class="hero-title">Tracking control for field teams.</h1>
                <p class="hero-copy">Update your tracking state, keep admins informed, and manage notifications from a straightforward interface designed for daily use.</p>
            </div>

            <div class="hero-grid">
                <div class="hero-stat"><div class="meta-label">Mode</div><div class="hero-stat-value" id="heroMode">{{ $currentStatus === 'online' ? 'Tracking On' : 'Tracking Off' }}</div></div>
                <div class="hero-stat"><div class="meta-label">Alerts</div><div class="hero-stat-value">Enabled</div></div>
                <div class="hero-stat"><div class="meta-label">Location</div><div class="hero-stat-value" id="heroLocationState">{{ $hasLocation ? 'Available' : 'Waiting' }}</div></div>
            </div>
        </section>

        <section class="control-card">
            <div class="control-accent {{ $currentStatus === 'online' ? 'online' : 'offline' }}" id="accentBar"></div>
            <div class="control-body">
                <div class="icon-ring {{ $currentStatus === 'online' ? 'online' : 'offline' }}" id="iconRing">{{ $currentStatus === 'online' ? 'Live' : 'Idle' }}</div>
                <div class="card-title">Driver Dashboard</div>
                <div class="card-sub">Tracking controls</div>

                <div class="status-row {{ $currentStatus === 'online' ? 'online' : 'offline' }}" id="statusRow">
                    <span class="status-dot {{ $currentStatus === 'online' ? 'online' : 'offline' }}" id="statusDot"></span>
                    <span class="status-label">Status</span>
                    <span class="status-value {{ $currentStatus === 'online' ? 'online' : 'offline' }}" id="statusValue">{{ $currentStatus === 'online' ? 'Online' : 'Offline' }}</span>
                </div>

                <div class="btn-group">
                    <button class="btn btn-start" id="btnStart" onclick="setStatus('online')" {{ $currentStatus === 'online' ? 'disabled' : '' }}>Start Tracking</button>
                    <button class="btn btn-stop" id="btnStop" onclick="setStatus('offline')" {{ $currentStatus === 'offline' ? 'disabled' : '' }}>Stop Tracking</button>
                </div>

                <button class="btn-notify" id="btnNotify" onclick="forceSubscribe()">Enable Notifications</button>
            </div>

            <div class="card-footer">
                <div class="footer-name">Driver: <span>{{ auth()->user()->name }}</span></div>
                <div class="session-clock" id="sessionClock">--:--:--</div>
            </div>
        </section>
    </div>
</div>

<script>
    const VAPID_KEY = '{{ config("webpush.vapid.public_key") }}';
    const CSRF = '{{ csrf_token() }}';

    function updateClock() {
        document.getElementById('sessionClock').textContent =
            new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
    }

    updateClock();
    setInterval(updateClock, 1000);

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const raw = atob(base64);
        return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
    }

    function setBtn(state, text) {
        const btn = document.getElementById('btnNotify');
        btn.className = 'btn-notify ' + state;
        btn.innerHTML = text;
        btn.disabled = (state === 'success');
        btn.onclick = state === 'success' ? null : forceSubscribe;
    }

    async function forceSubscribe() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            alert('Push notifications not supported on this browser.');
            return;
        }

        setBtn('', 'Subscribing...');
        document.getElementById('btnNotify').disabled = true;

        try {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                setBtn('error', 'Permission Denied');
                return;
            }

            const reg = await navigator.serviceWorker.ready;
            const old = await reg.pushManager.getSubscription();
            if (old) await old.unsubscribe();

            const sub = await reg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(VAPID_KEY)
            });

            const res = await fetch('/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify(sub.toJSON())
            });

            const data = await res.json();
            setBtn(data.success ? 'success' : 'error', data.success ? 'Notifications Enabled' : 'Server Error');
        } catch (err) {
            console.error('[FleetOS]', err);
            setBtn('error', 'Try Again');
        }
    }

    function setStatus(status) {
        const isOnline = status === 'online';
        ['accentBar', 'iconRing', 'statusRow', 'statusDot', 'statusValue'].forEach(id => {
            const el = document.getElementById(id);
            el.classList.toggle('online', isOnline);
            el.classList.toggle('offline', !isOnline);
        });

        document.getElementById('statusValue').textContent = isOnline ? 'Online' : 'Offline';
        document.getElementById('iconRing').textContent = isOnline ? 'Live' : 'Idle';
        document.getElementById('heroMode').textContent = isOnline ? 'Tracking On' : 'Tracking Off';
        document.getElementById('btnStart').disabled = isOnline;
        document.getElementById('btnStop').disabled = !isOnline;

        fetch('/update-status', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ status })
        });
    }
</script>

</x-app-layout>
