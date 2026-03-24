<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="FleetOS - Real-time vehicle tracking and driver status management">
    <meta name="author" content="FleetOS">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#f8fafc" id="themeColorMeta">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="FleetOS">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/icon-152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/icon-144.png">
    <meta name="msapplication-TileImage" content="/icons/icon-144.png">
    <meta name="msapplication-TileColor" content="#f8fafc">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/icon-96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/icon-72.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FleetOS') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        (() => {
            const savedTheme = localStorage.getItem('fleetos-theme');
            const theme = savedTheme === 'dark' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <style>
        :root {
            --app-bg: #f8fafc;
            --app-bg-soft: #eef2f7;
            --app-surface: rgba(255,255,255,0.94);
            --app-surface-strong: #ffffff;
            --app-border: #e2e8f0;
            --app-text: #0f172a;
            --app-text-soft: #475569;
            --app-text-muted: #64748b;
            --app-accent: #10b981;
            --app-accent-soft: #ecfdf5;
            --app-accent-border: #a7f3d0;
            --app-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
            --app-danger-soft: #fff1f2;
            --app-danger-border: #fecdd3;
            --app-danger-text: #be123c;
            --app-nav-bg: rgba(255,255,255,0.92);
        }

        html[data-theme="dark"] {
            --app-bg: #0b1120;
            --app-bg-soft: #0f172a;
            --app-surface: rgba(15,23,42,0.92);
            --app-surface-strong: #111827;
            --app-border: #1f2937;
            --app-text: #e5eef8;
            --app-text-soft: #9fb0c3;
            --app-text-muted: #7b8ca4;
            --app-accent: #34d399;
            --app-accent-soft: rgba(16,185,129,0.12);
            --app-accent-border: rgba(52,211,153,0.32);
            --app-shadow: 0 24px 52px rgba(2, 6, 23, 0.42);
            --app-danger-soft: rgba(244,63,94,0.12);
            --app-danger-border: rgba(251,113,133,0.28);
            --app-danger-text: #fda4af;
            --app-nav-bg: rgba(11,17,32,0.88);
        }

        body {
            background: var(--app-bg);
            color: var(--app-text);
            transition: background 0.2s ease, color 0.2s ease;
        }

        @media (max-width: 720px) {
            .app-main-shell {
                padding-bottom: calc(92px + env(safe-area-inset-bottom));
            }

            #pwaInstallBanner {
                bottom: calc(86px + env(safe-area-inset-bottom)) !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased" style="-webkit-tap-highlight-color:transparent;">
    <div class="min-h-screen" style="min-height:100dvh;">
        @include('layouts.navigation')

        @isset($header)
        <header>
            {{ $header }}
        </header>
        @endisset

        <main class="app-main-shell">
            {{ $slot }}
        </main>
    </div>

    <div id="pwaInstallBanner" style="
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: var(--app-surface-strong);
        border-top: 1px solid var(--app-border);
        padding: 16px 20px;
        padding-bottom: max(16px, env(safe-area-inset-bottom));
        z-index: 9999;
        box-shadow: 0 -8px 32px rgba(15,23,42,0.08);
        font-family: 'Inter', sans-serif;
    ">
        <div style="max-width:520px; margin:0 auto; display:flex; align-items:center; gap:14px;">
            <div style="
                width:44px; height:44px; flex-shrink:0;
                background:var(--app-accent-soft);
                border:1px solid var(--app-accent-border);
                border-radius:12px;
                display:flex; align-items:center; justify-content:center;
                font-size:0.72rem; font-family:'IBM Plex Mono', monospace; color:var(--app-accent);
                text-transform:uppercase; letter-spacing:0.12em;
            ">App</div>
            <div style="flex:1; min-width:0;">
                <div style="font-weight:700; font-size:0.92rem; color:var(--app-text);">Install FleetOS</div>
                <div style="font-size:0.78rem; color:var(--app-text-muted); margin-top:2px;">Add it to your home screen for faster access</div>
            </div>
            <button id="pwaInstallBtn" style="
                padding:10px 16px;
                background:var(--app-text);
                color:var(--app-surface-strong); border:none; border-radius:12px;
                font-family:'Inter',sans-serif; font-size:0.82rem; font-weight:600;
                cursor:pointer; flex-shrink:0;
                touch-action:manipulation;
            ">Install</button>
            <button id="pwaInstallDismiss" style="
                width:34px; height:34px; flex-shrink:0;
                background:var(--app-surface-strong); border:1px solid var(--app-border);
                border-radius:10px; color:var(--app-text-muted); cursor:pointer;
                display:flex; align-items:center; justify-content:center;
                font-size:1rem; touch-action:manipulation;
            ">×</button>
        </div>
    </div>

    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js', { scope: '/' })
                .catch(err => {
                    console.warn('[FleetOS] SW registration failed:', err);
                });
        });
    }

    const applyFleetTheme = (theme) => {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('fleetos-theme', theme);
        const meta = document.getElementById('themeColorMeta');
        if (meta) {
            meta.setAttribute('content', theme === 'dark' ? '#0b1120' : '#f8fafc');
        }
        window.dispatchEvent(new CustomEvent('fleetos-theme-change', { detail: { theme } }));
    };

    window.applyFleetTheme = applyFleetTheme;
    window.getFleetTheme = () => document.documentElement.getAttribute('data-theme') || 'light';

    let deferredInstallPrompt = null;
    const installBanner = document.getElementById('pwaInstallBanner');
    const installBtn = document.getElementById('pwaInstallBtn');
    const dismissBtn = document.getElementById('pwaInstallDismiss');
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches
                      || window.navigator.standalone === true;

    window.addEventListener('beforeinstallprompt', e => {
        e.preventDefault();
        deferredInstallPrompt = e;
        if (!isStandalone && !localStorage.getItem('pwaInstallDismissed')) {
            setTimeout(() => { installBanner.style.display = 'block'; }, 3000);
        }
    });

    installBtn?.addEventListener('click', async () => {
        if (!deferredInstallPrompt) return;
        deferredInstallPrompt.prompt();
        await deferredInstallPrompt.userChoice;
        deferredInstallPrompt = null;
        installBanner.style.display = 'none';
    });

    dismissBtn?.addEventListener('click', () => {
        installBanner.style.display = 'none';
        localStorage.setItem('pwaInstallDismissed', '1');
    });

    async function requestPushPermission() {
        if (!('Notification' in window)) return;
        if (Notification.permission === 'granted') return;
        if (Notification.permission === 'denied') return;
        if (localStorage.getItem('pushPermissionAsked')) return;

        setTimeout(async () => {
            const permission = await Notification.requestPermission();
            localStorage.setItem('pushPermissionAsked', '1');
            if (permission === 'granted') {
                subscribeToPush();
            }
        }, 5000);
    }

    async function subscribeToPush() {
        try {
            const reg = await navigator.serviceWorker.ready;
            const VAPID_PUBLIC_KEY = 'BLQt68_Zg4QRnX21TRpzYjBq7f48cE68uNJV-awMY0jCDe67-z2Ne9es8X-HI3aLXhtbVAWItWaeg21gqK_ORiY';

            const subscription = await reg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY),
            });

            await fetch('/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(subscription),
            });
        } catch (err) {
            console.warn('[FleetOS] Push subscription failed:', err);
        }
    }

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const raw = atob(base64);
        return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
    }

    @auth
    requestPushPermission();
    @endauth
    </script>
</body>
</html>
