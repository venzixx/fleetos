<x-app-layout>
    <style>
        .profile-wrap {
            min-height: calc(100vh - 72px);
            min-height: calc(100dvh - 72px);
            background:
                radial-gradient(circle at top, color-mix(in srgb, var(--app-accent) 18%, transparent), transparent 30%),
                linear-gradient(180deg, var(--app-bg) 0%, var(--app-bg-soft) 100%);
            padding: 24px 16px 42px;
        }

        .profile-shell {
            max-width: 1120px;
            margin: 0 auto;
            display: grid;
            gap: 22px;
        }

        .profile-hero,
        .profile-card {
            border: 1px solid var(--app-border);
            border-radius: 24px;
            background: color-mix(in srgb, var(--app-surface) 92%, transparent);
            box-shadow: var(--app-shadow);
        }

        .profile-hero {
            padding: 28px;
        }

        .profile-kicker {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--app-text-muted);
        }

        .profile-title {
            margin-top: 12px;
            font-size: clamp(1.9rem, 4.5vw, 3.3rem);
            line-height: 1.02;
            letter-spacing: -0.045em;
            font-weight: 700;
            color: var(--app-text);
            max-width: 10ch;
        }

        .profile-copy {
            margin-top: 18px;
            max-width: 60ch;
            color: var(--app-text-soft);
            font-size: 0.98rem;
            line-height: 1.75;
        }

        .profile-card {
            padding: 22px;
        }

        .profile-card.danger {
            border-color: var(--app-danger-border);
            background: color-mix(in srgb, var(--app-danger-soft) 58%, var(--app-surface-strong) 42%);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.04);
        }

        .profile-mobile-actions {
            display: none;
        }

        .profile-mobile-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .profile-mobile-link,
        .profile-mobile-button {
            min-height: 52px;
            border-radius: 16px;
            border: 1px solid var(--app-border);
            background: color-mix(in srgb, var(--app-surface-strong) 82%, transparent);
            color: var(--app-text);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
        }

        .profile-mobile-button {
            cursor: pointer;
        }

        @media (max-width: 720px) {
            .profile-wrap {
                padding: 10px 10px 34px;
                overflow-x: clip;
            }

            .profile-hero,
            .profile-card {
                border-radius: 22px;
            }

            .profile-hero {
                padding: 22px 20px;
            }

            .profile-card {
                padding: 20px;
            }

            .profile-title {
                max-width: none;
            }

            .profile-mobile-actions {
                display: block;
            }
        }
    </style>

    <div class="profile-wrap">
        <div class="profile-shell">
            <section class="profile-hero">
                <div class="profile-kicker">Account settings</div>
                <h1 class="profile-title">Manage your profile and security.</h1>
                <p class="profile-copy">
                    Update your personal details, keep your password secure, and manage account access from one place that works cleanly across desktop and mobile.
                </p>

                <div class="profile-mobile-actions">
                    <div class="profile-mobile-grid">
                        <button type="button" class="profile-mobile-button" id="profileThemeToggle">Switch Theme</button>
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="profile-mobile-link">Admin Panel</a>
                        @else
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="profile-mobile-button">Log Out</button>
                            </form>
                        @endif
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
                            @csrf
                            <button type="submit" class="profile-mobile-button" style="width:100%;">Log Out</button>
                        </form>
                    @endif
                </div>
            </section>

            <div style="display:grid; gap:18px;">
                <div class="profile-card">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="profile-card">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="profile-card danger">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profileThemeToggle')?.addEventListener('click', () => {
            const currentTheme = window.getFleetTheme ? window.getFleetTheme() : 'light';
            window.applyFleetTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });
    </script>
</x-app-layout>
