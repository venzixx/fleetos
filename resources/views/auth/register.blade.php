<x-guest-layout>
    <div style="border:1px solid #1a1e2e; border-radius:28px; overflow:hidden; background:#0f1117; box-shadow:0 0 0 1px rgba(16,185,129,0.04), 0 32px 80px rgba(0,0,0,0.55);">
        <div style="height:4px; background:linear-gradient(90deg, #059669, #10b981, #34d399);"></div>

        <div style="padding:28px 22px 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:22px;">
                <div>
                    <div style="font-family:'DM Mono', monospace; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.14em; color:#34d399;">New driver setup</div>
                    <h2 style="font-family:'Syne', sans-serif; font-size:clamp(1.6rem, 4vw, 2rem); line-height:1.05; font-weight:800; letter-spacing:-0.03em; color:#f8fafc; margin-top:8px;">
                        Create your FleetOS account
                    </h2>
                </div>
                <div style="width:52px; height:52px; border-radius:16px; background:rgba(16,185,129,0.10); border:1px solid rgba(16,185,129,0.20); display:flex; align-items:center; justify-content:center; color:#34d399; font-size:1.2rem;">
                    ID
                </div>
            </div>

            <p style="font-size:0.95rem; line-height:1.65; color:#94a3b8; margin-bottom:22px;">
                Set up access for tracking and notifications with a clean mobile-friendly registration flow.
            </p>

            <form method="POST" action="{{ route('register') }}" style="display:grid; gap:16px;">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" style="color:#cbd5e1; font-weight:700; margin-bottom:8px;" />
                    <x-text-input id="name" class="block w-full border-[#1f2937] bg-[#0a0c14] text-slate-100 placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-none px-4 py-3.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-400" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" style="color:#cbd5e1; font-weight:700; margin-bottom:8px;" />
                    <x-text-input id="email" class="block w-full border-[#1f2937] bg-[#0a0c14] text-slate-100 placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-none px-4 py-3.5" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="driver@fleetos.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-400" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" style="color:#cbd5e1; font-weight:700; margin-bottom:8px;" />
                    <x-text-input id="password" class="block w-full border-[#1f2937] bg-[#0a0c14] text-slate-100 placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-none px-4 py-3.5" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" style="color:#cbd5e1; font-weight:700; margin-bottom:8px;" />
                    <x-text-input id="password_confirmation" class="block w-full border-[#1f2937] bg-[#0a0c14] text-slate-100 placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-none px-4 py-3.5" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-400" />
                </div>

                <div style="display:grid; gap:12px; margin-top:6px;">
                    <x-primary-button class="w-full justify-center rounded-2xl px-4 py-3.5 text-sm font-bold tracking-[0.16em] uppercase bg-emerald-500 hover:bg-emerald-400 focus:bg-emerald-400 active:bg-emerald-600 text-slate-950 shadow-none border-0">
                        {{ __('Register') }}
                    </x-primary-button>

                    <a href="{{ route('login') }}" style="display:flex; align-items:center; justify-content:center; min-height:54px; border-radius:18px; border:1px solid #1f2937; background:rgba(10,12,20,0.92); color:#cbd5e1; font-weight:700; text-decoration:none;">
                        Already registered? Log in
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
