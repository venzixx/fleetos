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
<body style="margin:0; background:#f8fafc; color:#0f172a; -webkit-tap-highlight-color:transparent; font-family:'Inter', sans-serif;">
    <div style="min-height:100vh; min-height:100dvh; background:
        radial-gradient(circle at top, rgba(16,185,129,0.08), transparent 32%),
        linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);">
        <div style="padding:20px 16px 40px; padding-top:max(20px, env(safe-area-inset-top)); padding-bottom:max(40px, env(safe-area-inset-bottom));">
            <div style="max-width:1160px; margin:0 auto;">
                <header style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:44px;">
                    <a href="{{ url('/') }}" style="display:inline-flex; flex-direction:column; gap:4px; text-decoration:none; color:inherit;">
                        <div style="font-family:'IBM Plex Mono', monospace; font-size:0.7rem; letter-spacing:0.18em; text-transform:uppercase; color:#059669;">FleetOS</div>
                        <div style="font-weight:700; font-size:clamp(1rem, 2vw, 1.2rem); letter-spacing:-0.02em; color:#0f172a;">Vehicle Tracker</div>
                    </a>

                    <nav style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        @auth
                            <a href="{{ url('/dashboard') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:44px; padding:0 18px; border-radius:14px; background:#0f172a; color:#fff; font-weight:600; text-decoration:none;">
                                Open Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:44px; padding:0 18px; border-radius:14px; border:1px solid #e2e8f0; background:#fff; color:#334155; font-weight:600; text-decoration:none;">
                                Log In
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:44px; padding:0 18px; border-radius:14px; background:#0f172a; color:#fff; font-weight:600; text-decoration:none;">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                </header>

                <section class="fleet-hero-grid" style="display:grid; grid-template-columns:minmax(0, 1.1fr) minmax(320px, 420px); gap:26px; align-items:center;">
                    <div style="padding:10px 0;">
                        <div style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:#64748b; margin-bottom:14px;">
                            Fleet operations platform
                        </div>

                        <h1 style="font-size:clamp(2.3rem, 6vw, 4.85rem); line-height:1; letter-spacing:-0.05em; font-weight:700; color:#0f172a; max-width:10ch; margin:0;">
                            Tracking built for company workflows.
                        </h1>

                        <p style="max-width:620px; margin:22px 0 0; color:#475569; font-size:1rem; line-height:1.8;">
                            FleetOS helps drivers update tracking in seconds while keeping administrators informed through a clear, mobile-ready interface with notifications and room to grow into live maps and operational tools.
                        </p>

                        <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:26px;">
                            @auth
                                <a href="{{ url('/dashboard') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:50px; padding:0 22px; border-radius:16px; background:#0f172a; color:#fff; font-weight:600; text-decoration:none;">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:50px; padding:0 22px; border-radius:16px; background:#0f172a; color:#fff; font-weight:600; text-decoration:none;">
                                    Log In
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" style="display:inline-flex; align-items:center; justify-content:center; min-height:50px; padding:0 22px; border-radius:16px; border:1px solid #e2e8f0; background:#fff; color:#334155; font-weight:600; text-decoration:none;">
                                        Create Account
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div style="border:1px solid #e2e8f0; border-radius:24px; overflow:hidden; background:#ffffff; box-shadow:0 20px 40px rgba(15, 23, 42, 0.06);">
                        <div style="height:3px; background:#10b981;"></div>
                        <div style="padding:22px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; gap:12px;">
                                <div>
                                    <div style="font-family:'IBM Plex Mono', monospace; font-size:0.68rem; letter-spacing:0.14em; text-transform:uppercase; color:#64748b;">Live overview</div>
                                    <div style="margin-top:8px; color:#0f172a; font-size:1.3rem; font-weight:700;">Driver status</div>
                                </div>
                                <div style="display:flex; align-items:center; gap:8px; padding:9px 12px; border-radius:999px; background:#ecfdf5; border:1px solid #a7f3d0;">
                                    <span style="width:8px; height:8px; border-radius:50%; background:#10b981;"></span>
                                    <span style="font-family:'IBM Plex Mono', monospace; font-size:0.68rem; text-transform:uppercase; color:#065f46;">Tracking on</span>
                                </div>
                            </div>

                            <div style="display:grid; gap:12px;">
                                <div style="border:1px solid #e2e8f0; border-radius:16px; background:#fff; padding:16px;">
                                    <div style="font-family:'IBM Plex Mono', monospace; font-size:0.66rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Notifications</div>
                                    <div style="margin-top:8px; color:#0f172a; font-weight:700;">Admin alerts</div>
                                    <div style="margin-top:6px; color:#475569; font-size:0.92rem; line-height:1.7;">Receive immediate updates when drivers enable or disable tracking.</div>
                                </div>

                                <div style="border:1px solid #e2e8f0; border-radius:16px; background:#fff; padding:16px;">
                                    <div style="font-family:'IBM Plex Mono', monospace; font-size:0.66rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Mobile</div>
                                    <div style="margin-top:8px; color:#0f172a; font-weight:700;">PWA ready</div>
                                    <div style="margin-top:6px; color:#475569; font-size:0.92rem; line-height:1.7;">Optimized for phones with app-style navigation and space for future map tools.</div>
                                </div>

                                <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:12px;">
                                    <div style="border:1px solid #e2e8f0; border-radius:16px; background:#fff; padding:16px;">
                                        <div style="font-family:'IBM Plex Mono', monospace; font-size:0.66rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Drivers</div>
                                        <div style="margin-top:8px; color:#0f172a; font-size:1.1rem; font-weight:700;">Fast</div>
                                    </div>
                                    <div style="border:1px solid #e2e8f0; border-radius:16px; background:#fff; padding:16px;">
                                        <div style="font-family:'IBM Plex Mono', monospace; font-size:0.66rem; text-transform:uppercase; letter-spacing:0.12em; color:#64748b;">Admins</div>
                                        <div style="margin-top:8px; color:#0f172a; font-size:1.1rem; font-weight:700;">Visible</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
            .fleet-hero-grid { grid-template-columns: 1fr !important; }
            h1 { max-width: none !important; }
        }
    </style>
</body>
</html>
