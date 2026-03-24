<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');

.nav-root {
    font-family: 'Inter', sans-serif;
    position: sticky;
    top: 0;
    z-index: 1200;
    background: color-mix(in srgb, var(--app-nav-bg) 78%, transparent);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid color-mix(in srgb, var(--app-border) 92%, transparent);
    box-shadow: 0 8px 28px rgba(15, 23, 42, 0.06);
}

.nav-root.maps-overlay {
    position: fixed;
    top: calc(12px + env(safe-area-inset-top));
    left: 12px;
    right: 12px;
    z-index: 1950;
    width: auto;
    border-radius: 20px;
    border: 1px solid rgba(148, 163, 184, 0.18);
    background: color-mix(in srgb, var(--app-nav-bg) 66%, transparent);
    box-shadow: 0 20px 52px rgba(15, 23, 42, 0.12);
    backdrop-filter: blur(22px) saturate(150%);
}

.nav-inner {
    max-width: 1120px;
    margin: 0 auto;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.nav-brand {
    display: inline-flex;
    flex-direction: column;
    gap: 2px;
    text-decoration: none;
    min-width: 0;
}

.nav-brand-kicker {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 0.67rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--app-accent);
}

.nav-brand-name {
    color: var(--app-text);
    font-size: 1rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1.1;
}

.nav-center {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 0 14px;
    border-radius: 12px;
    border: 1px solid transparent;
    text-decoration: none;
    color: var(--app-text-soft);
    font-size: 0.9rem;
    font-weight: 600;
    transition: background 0.16s ease, color 0.16s ease, border-color 0.16s ease;
}

.nav-link:hover {
    background: color-mix(in srgb, var(--app-surface-strong) 92%, transparent);
    border-color: var(--app-border);
    color: var(--app-text);
}

.nav-link.active {
    background: var(--app-accent-soft);
    border-color: var(--app-accent-border);
    color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
}

.nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.theme-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    border: 1px solid var(--app-border);
    background: color-mix(in srgb, var(--app-surface-strong) 82%, transparent);
    color: var(--app-text);
    cursor: pointer;
}

.theme-toggle svg {
    width: 18px;
    height: 18px;
}

.role-pill {
    display: inline-flex;
    align-items: center;
    min-height: 34px;
    padding: 0 12px;
    border-radius: 999px;
    border: 1px solid var(--app-accent-border);
    background: var(--app-accent-soft);
    color: var(--app-accent);
    font-family: 'IBM Plex Mono', monospace;
    font-size: 0.66rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
}

.user-menu { position: relative; }

.user-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 42px;
    padding: 5px 8px 5px 5px;
    border-radius: 14px;
    border: 1px solid var(--app-border);
    background: color-mix(in srgb, var(--app-surface-strong) 82%, transparent);
    cursor: pointer;
}

.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--app-accent-soft);
    color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
    font-weight: 700;
    font-size: 0.8rem;
    flex-shrink: 0;
}

.user-name-text {
    color: var(--app-text);
    font-size: 0.88rem;
    font-weight: 600;
    max-width: 120px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chevron {
    width: 14px;
    height: 14px;
    color: var(--app-text-muted);
    transition: transform 0.18s ease;
}

.user-menu.open .chevron { transform: rotate(180deg); }

.dropdown-panel {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    min-width: 240px;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--app-border);
    background: color-mix(in srgb, var(--app-surface-strong) 94%, transparent);
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
}

.user-menu.open .dropdown-panel { display: block; }

.dropdown-header {
    padding: 16px;
    border-bottom: 1px solid var(--app-border);
}

.dropdown-user-name {
    color: var(--app-text);
    font-size: 0.92rem;
    font-weight: 700;
}

.dropdown-user-email {
    margin-top: 4px;
    color: var(--app-text-muted);
    font-size: 0.76rem;
    word-break: break-word;
}

.dropdown-item {
    display: flex;
    align-items: center;
    width: 100%;
    min-height: 44px;
    padding: 0 16px;
    border: 0;
    background: transparent;
    color: var(--app-text-soft);
    text-decoration: none;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
}

.dropdown-item:hover {
    background: color-mix(in srgb, var(--app-surface) 88%, transparent);
    color: var(--app-text);
}

.dropdown-item.danger:hover {
    background: var(--app-danger-soft);
    color: var(--app-danger-text);
}

.dropdown-divider {
    height: 1px;
    background: var(--app-border);
}

.mobile-bottom-nav {
    display: none;
    position: fixed;
    left: 12px;
    right: 12px;
    bottom: calc(12px + env(safe-area-inset-bottom));
    z-index: 2100;
    border: 1px solid color-mix(in srgb, var(--app-border) 86%, rgba(255,255,255,0.24));
    border-radius: 22px;
    background:
        linear-gradient(180deg, color-mix(in srgb, var(--app-surface-strong) 84%, transparent), color-mix(in srgb, var(--app-nav-bg) 68%, transparent));
    backdrop-filter: blur(24px) saturate(155%);
    -webkit-backdrop-filter: blur(24px) saturate(155%);
    box-shadow:
        0 22px 48px rgba(15, 23, 42, 0.18),
        inset 0 1px 0 rgba(255, 255, 255, 0.28);
    padding: 8px;
    gap: 6px;
}

.mobile-bottom-nav.three {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.mobile-bottom-nav.four {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}

.mobile-bottom-item {
    min-height: 58px;
    border-radius: 16px;
    border: 1px solid transparent;
    background: transparent;
    color: var(--app-text-muted);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    font-size: 0.72rem;
    font-weight: 600;
    cursor: pointer;
}

.mobile-bottom-item svg {
    width: 20px;
    height: 20px;
}

.mobile-bottom-item.active {
    background: color-mix(in srgb, var(--app-accent-soft) 82%, rgba(255,255,255,0.16));
    border-color: var(--app-accent-border);
    color: color-mix(in srgb, var(--app-accent) 70%, var(--app-text) 30%);
    box-shadow: inset 0 0 0 1px rgba(16,185,129,0.08);
}

.mobile-bottom-item.soon {
    opacity: 0.75;
}

@media (max-width: 980px) {
    .role-pill { display: none; }
}

@media (max-width: 720px) {
    .nav-links, .user-menu, .role-pill { display: none; }
    .nav-inner { padding: 12px 16px; }
    .nav-center { flex: 1; min-width: 0; }
    .nav-brand-kicker { font-size: 0.66rem; }
    .nav-brand-name { font-size: 1.02rem; }
    .nav-right { gap: 0; }
    .mobile-bottom-nav { display: grid; }
    .nav-root.maps-overlay {
        top: calc(10px + env(safe-area-inset-top));
        left: 10px;
        right: 10px;
        border-radius: 18px;
    }
}
</style>

@php
    $isDashboard = request()->routeIs('dashboard');
    $isMaps = request()->routeIs('maps');
    $isProfile = request()->routeIs('profile.*');
    $isAdmin = request()->is('admin*');
    $mobileNavClass = Auth::user()->role === 'admin' ? 'four' : 'three';
@endphp

<nav class="nav-root {{ $isMaps ? 'maps-overlay' : '' }}">
    <div class="nav-inner">
        <div class="nav-center">
            <a href="{{ route('dashboard') }}" class="nav-brand">
                <span class="nav-brand-kicker">FleetOS</span>
                <span class="nav-brand-name">Vehicle Tracker</span>
            </a>

            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="nav-link {{ $isDashboard ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('maps') }}" class="nav-link {{ $isMaps ? 'active' : '' }}">Maps</a>
                @if(Auth::user()->role === 'admin')
                    <a href="/admin" class="nav-link {{ $isAdmin ? 'active' : '' }}">Admin Panel</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="nav-link {{ $isProfile ? 'active' : '' }}">Profile</a>
            </div>
        </div>

        <div class="nav-right">
            <button type="button" class="theme-toggle" id="desktopThemeToggle" aria-label="Toggle theme">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2.2M12 18.8V21M4.9 4.9l1.6 1.6M17.5 17.5l1.6 1.6M3 12h2.2M18.8 12H21M4.9 19.1l1.6-1.6M17.5 6.5l1.6-1.6M12 16a4 4 0 100-8 4 4 0 000 8z"/></svg>
            </button>

            <span class="role-pill">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Driver' }}</span>

            <div class="user-menu" id="userMenu">
                <button type="button" class="user-trigger" id="userMenuButton" aria-expanded="false" aria-controls="userDropdown">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span class="user-name-text">{{ Auth::user()->name }}</span>
                    <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div class="dropdown-panel" id="userDropdown">
                    <div class="dropdown-header">
                        <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
                    </div>
                    @if(Auth::user()->role === 'admin')
                        <a href="/admin" class="dropdown-item">Admin Panel</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                    <button type="button" class="dropdown-item" id="desktopThemeMenuToggle">Switch Theme</button>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="mobile-bottom-nav {{ $mobileNavClass }}" id="mobileBottomNav">
    <a href="{{ route('dashboard') }}" class="mobile-bottom-item {{ $isDashboard ? 'active' : '' }}">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-8 9 8M5 10v9h14v-9"/></svg>
        <span>Home</span>
    </a>

    <a href="{{ route('maps') }}" class="mobile-bottom-item {{ $isMaps ? 'active' : '' }}">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5-2V6l5 2 6-2 5 2v12l-5-2-6 2z"/></svg>
        <span>Maps</span>
    </a>

    @if(Auth::user()->role === 'admin')
        <a href="/admin" class="mobile-bottom-item {{ $isAdmin ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4a4 4 0 100 8 4 4 0 000-8zm0 10c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/></svg>
            <span>Admin</span>
        </a>
    @endif

    <a href="{{ route('profile.edit') }}" class="mobile-bottom-item {{ $isProfile ? 'active' : '' }}">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/></svg>
        <span>Profile</span>
    </a>
</div>

<script>
(() => {
    const userMenu = document.getElementById('userMenu');
    const userMenuButton = document.getElementById('userMenuButton');
    const desktopThemeToggle = document.getElementById('desktopThemeToggle');
    const desktopThemeMenuToggle = document.getElementById('desktopThemeMenuToggle');

    const toggleTheme = () => {
        const currentTheme = window.getFleetTheme ? window.getFleetTheme() : 'light';
        window.applyFleetTheme(currentTheme === 'dark' ? 'light' : 'dark');
    };

    if (userMenu && userMenuButton) {
        userMenuButton.addEventListener('click', (event) => {
            event.stopPropagation();
            const isOpen = userMenu.classList.toggle('open');
            userMenuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target)) {
                userMenu.classList.remove('open');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    desktopThemeToggle?.addEventListener('click', toggleTheme);
    desktopThemeMenuToggle?.addEventListener('click', toggleTheme);
})();
</script>
