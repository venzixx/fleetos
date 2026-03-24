<section>
    <style>
        .profile-section {
            font-family: 'Inter', sans-serif;
        }

        .profile-section .profile-form-grid {
            display: grid;
            gap: 18px;
            margin-top: 24px;
        }

        .profile-section .profile-field {
            display: grid;
            gap: 8px;
        }

        .profile-section .profile-label {
            display: block;
            color: var(--app-text-soft);
            font-size: 0.92rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .profile-section .profile-input {
            display: block;
            box-sizing: border-box;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            min-height: 58px;
            border-radius: 18px;
            border: 1px solid var(--app-border);
            background: var(--app-surface-strong);
            color: var(--app-text);
            padding: 0 18px;
            font-size: 16px;
            line-height: 1.2;
            font-family: 'Inter', sans-serif;
            outline: none;
            box-shadow: none;
            appearance: none;
            -webkit-appearance: none;
        }

        .profile-section .profile-input::placeholder {
            color: var(--app-text-muted);
        }

        .profile-section .profile-input:focus {
            border-color: var(--app-accent);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--app-accent) 14%, transparent);
        }

        .profile-section .profile-note {
            margin-top: 14px;
            border: 1px solid var(--app-border);
            border-radius: 16px;
            background: color-mix(in srgb, var(--app-surface) 88%, transparent);
            padding: 14px;
        }

        .profile-section .profile-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 4px;
        }

        .profile-section .profile-save {
            display: inline-flex;
            box-sizing: border-box;
            align-items: center;
            justify-content: center;
            min-height: 56px;
            padding: 0 24px;
            max-width: 100%;
            border-radius: 16px;
            border: none;
            background: var(--app-text);
            color: var(--app-surface-strong);
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            appearance: none;
            -webkit-appearance: none;
        }

        @media (max-width: 720px) {
            .profile-section .profile-field {
                min-width: 0;
            }

            .profile-section .profile-form-grid {
                gap: 16px;
            }

            .profile-section .profile-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .profile-section .profile-save {
                width: 100%;
            }
        }
    </style>

    <div class="profile-section">
    <header>
        <h2 style="font-size:1.2rem; font-weight:700; color:var(--app-text); letter-spacing:-0.02em;">
            {{ __('Profile Information') }}
        </h2>

        <p style="margin-top:8px; font-size:0.95rem; line-height:1.7; color:var(--app-text-soft); max-width:60ch;">
            {{ __("Update your account details and keep your email address current.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form-grid">
        @csrf
        @method('patch')

        <div class="profile-field">
            <label for="name" class="profile-label">{{ __('Name') }}</label>
            <input
                id="name"
                name="name"
                type="text"
                class="profile-input"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >
            <x-input-error class="mt-1 text-sm text-red-500" :messages="$errors->get('name')" />
        </div>

        <div class="profile-field">
            <label for="email" class="profile-label">{{ __('Email') }}</label>
            <input
                id="email"
                name="email"
                type="email"
                class="profile-input"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >
            <x-input-error class="mt-1 text-sm text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="profile-note">
                    <p style="font-size:0.92rem; line-height:1.7; color:var(--app-text-soft);">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" style="display:inline; border:none; background:none; padding:0; color:var(--app-text); font-weight:600; text-decoration:underline; cursor:pointer;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top:8px; font-size:0.88rem; font-weight:600; color:var(--app-accent);">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="profile-actions">
            <button type="submit" class="profile-save">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size:0.9rem; color:var(--app-accent); font-weight:600;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    </div>
</section>
