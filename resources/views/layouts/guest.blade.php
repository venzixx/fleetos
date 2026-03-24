<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="FleetOS - Real-time vehicle tracking and driver status management">
    <meta name="theme-color" content="#f8fafc">
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="FleetOS">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/icon-96.png">
    <title>{{ config('app.name', 'FleetOS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background:#f8fafc; color:#0f172a; -webkit-tap-highlight-color:transparent; font-family:'Inter', sans-serif;">
    <div style="min-height:100vh; min-height:100dvh; background:
        radial-gradient(circle at top, rgba(16,185,129,0.08), transparent 34%),
        linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);">
        <div style="min-height:100vh; min-height:100dvh; display:flex; align-items:center; justify-content:center; padding:24px 16px 32px; padding-top:max(24px, env(safe-area-inset-top)); padding-bottom:max(32px, env(safe-area-inset-bottom));">
            <div class="fleet-guest-shell" style="width:100%; max-width:1100px; display:grid; grid-template-columns:minmax(0, 1fr) minmax(320px, 410px); gap:28px; align-items:center;">
                <div class="fleet-guest-brand" style="display:flex; flex-direction:column; gap:20px; padding:8px 4px;">
                    <a href="{{ url('/') }}" style="display:inline-flex; flex-direction:column; gap:4px; width:max-content; text-decoration:none;">
                        <div style="font-family:'IBM Plex Mono', monospace; font-size:0.7rem; letter-spacing:0.18em; text-transform:uppercase; color:#059669;">FleetOS</div>
                        <div style="font-weight:700; font-size:clamp(1rem, 2vw, 1.2rem); letter-spacing:-0.02em; color:#0f172a;">Vehicle Tracker</div>
                    </a>

                    <div>
                        <div style="font-family:'IBM Plex Mono', monospace; font-size:0.7rem; letter-spacing:0.14em; text-transform:uppercase; color:#64748b; margin-bottom:12px;">Realtime operations</div>
                        <h1 style="font-size:clamp(2rem, 5vw, 3.85rem); line-height:1.02; font-weight:700; letter-spacing:-0.045em; color:#0f172a; max-width:10ch;">
                            Fleet tracking for modern teams.
                        </h1>
                    </div>

                    <p style="max-width:560px; font-size:1rem; line-height:1.75; color:#475569;">
                        Built for companies that need a clean driver workflow, instant status visibility, and reliable access from desktop or installed PWA.
                    </p>

                    <div class="fleet-feature-grid" style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:12px; max-width:620px;">
                        <div style="border:1px solid #e2e8f0; border-radius:18px; background:#ffffff; padding:16px;">
                            <div style="font-family:'IBM Plex Mono', monospace; font-size:0.67rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Tracking</div>
                            <div style="margin-top:8px; font-weight:600; color:#0f172a;">Live controls</div>
                        </div>
                        <div style="border:1px solid #e2e8f0; border-radius:18px; background:#ffffff; padding:16px;">
                            <div style="font-family:'IBM Plex Mono', monospace; font-size:0.67rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Notifications</div>
                            <div style="margin-top:8px; font-weight:600; color:#0f172a;">Admin alerts</div>
                        </div>
                        <div style="border:1px solid #e2e8f0; border-radius:18px; background:#ffffff; padding:16px;">
                            <div style="font-family:'IBM Plex Mono', monospace; font-size:0.67rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Access</div>
                            <div style="margin-top:8px; font-weight:600; color:#0f172a;">Phone ready</div>
                        </div>
                    </div>
                </div>

                <div style="width:100%;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js', { scope: '/' }).catch(() => {});
            });
        }
    </script>

    <style>
        @media (max-width: 900px) {
            .fleet-guest-shell { grid-template-columns: 1fr !important; max-width: 460px; }
            .fleet-guest-brand { padding: 0; }
            .fleet-guest-brand h1 { max-width: none !important; }
        }

        @media (max-width: 640px) {
            .fleet-feature-grid { grid-template-columns: 1fr !important; }
        }
    </style>
</body>
</html>
