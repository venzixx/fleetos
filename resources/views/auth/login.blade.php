<x-guest-layout>
    <div style="border:1px solid #e2e8f0; border-radius:24px; overflow:hidden; background:#ffffff; box-shadow:0 20px 40px rgba(15, 23, 42, 0.06);">
        <div style="height:3px; background:#10b981;"></div>

        <div style="padding:28px 22px 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:20px;">
                <div>
                    <div style="font-family:'IBM Plex Mono', monospace; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.14em; color:#64748b;">Driver access</div>
                    <h2 style="font-size:clamp(1.6rem, 4vw, 2rem); line-height:1.05; font-weight:700; letter-spacing:-0.03em; color:#0f172a; margin-top:8px;">
                        Log in to FleetOS
                    </h2>
                </div>
                <div style="min-width:52px; height:40px; border-radius:12px; background:#ecfdf5; border:1px solid #d1fae5; display:flex; align-items:center; justify-content:center; color:#047857; font-size:0.72rem; font-family:'IBM Plex Mono', monospace; text-transform:uppercase; letter-spacing:0.12em; padding:0 12px;">
                    Live
                </div>
            </div>

            <p style="font-size:0.95rem; line-height:1.7; color:#475569; margin-bottom:22px;">
                Sign in to manage tracking, update your live status, and receive company notifications from one streamlined dashboard.
            </p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" style="display:grid; gap:16px;">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" style="color:#334155; font-weight:600; margin-bottom:8px;" />
                    <x-text-input id="email" class="block w-full border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-none px-4 py-3.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="driver@fleetos.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <div>
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:8px;">
                        <x-input-label for="password" :value="__('Password')" style="color:#334155; font-weight:600;" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:0.82rem; color:#0f172a; text-decoration:none;">Forgot password?</a>
                        @endif
                    </div>

                    <x-text-input id="password" class="block w-full border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-none px-4 py-3.5" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <label for="remember_me" class="remember-wrap" style="display:flex; align-items:center; gap:12px; font-size:0.92rem; color:#475569; cursor:pointer; width:max-content;">
                    <span class="remember-box" style="position:relative; width:22px; height:22px; border-radius:7px; border:1px solid #cbd5e1; background:#ffffff; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <input id="remember_me" type="checkbox" name="remember" style="position:absolute; inset:0; opacity:0; cursor:pointer;">
                        <span class="remember-check" style="width:10px; height:6px; border-left:2px solid transparent; border-bottom:2px solid transparent; transform:rotate(-45deg) translateY(-1px);"></span>
                    </span>
                    <span>Keep me signed in</span>
                </label>

                <div style="display:grid; gap:12px; margin-top:6px;">
                    <x-primary-button class="w-full justify-center rounded-2xl px-4 py-3.5 text-sm font-semibold tracking-[0.12em] uppercase bg-slate-900 hover:bg-slate-800 focus:bg-slate-800 active:bg-black text-white shadow-none border-0">
                        {{ __('Log in') }}
                    </x-primary-button>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" style="display:flex; align-items:center; justify-content:center; min-height:54px; border-radius:18px; border:1px solid #e2e8f0; background:#ffffff; color:#334155; font-weight:600; text-decoration:none;">
                            Create a new account
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <style>
        .remember-wrap:has(#remember_me:checked) .remember-box {
            background: #10b981 !important;
            border-color: #10b981 !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
        }

        .remember-wrap:has(#remember_me:checked) .remember-check {
            border-left-color: #ffffff;
            border-bottom-color: #ffffff;
        }

        .remember-wrap:has(#remember_me:focus-visible) .remember-box {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.14);
        }
    </style>
</x-guest-layout>
