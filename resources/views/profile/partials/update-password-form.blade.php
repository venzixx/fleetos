<section>
    <style>
        .password-section {
            font-family: 'Inter', sans-serif;
        }

        .password-section .password-form-grid {
            display: grid;
            gap: 18px;
            margin-top: 24px;
        }

        .password-section .password-field {
            display: grid;
            gap: 8px;
        }

        .password-section .password-label {
            display: block;
            color: var(--app-text-soft);
            font-size: 0.92rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .password-section .password-input {
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

        .password-section .password-input:focus {
            border-color: var(--app-accent);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--app-accent) 14%, transparent);
        }

        .password-section .password-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 4px;
        }

        .password-section .password-save {
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
            .password-section .password-field {
                min-width: 0;
            }

            .password-section .password-form-grid {
                gap: 16px;
            }

            .password-section .password-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .password-section .password-save {
                width: 100%;
            }
        }
    </style>

    <div class="password-section">
    <header>
        <h2 style="font-size:1.2rem; font-weight:700; color:var(--app-text); letter-spacing:-0.02em;">
            {{ __('Update Password') }}
        </h2>

        <p style="margin-top:8px; font-size:0.95rem; line-height:1.7; color:var(--app-text-soft); max-width:60ch;">
            {{ __('Use a strong password to keep your account secure across devices.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="password-form-grid">
        @csrf
        @method('put')

        <div class="password-field">
            <label for="update_password_current_password" class="password-label">{{ __('Current Password') }}</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="password-input"
                autocomplete="current-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-sm text-red-500" />
        </div>

        <div class="password-field">
            <label for="update_password_password" class="password-label">{{ __('New Password') }}</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="password-input"
                autocomplete="new-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-sm text-red-500" />
        </div>

        <div class="password-field">
            <label for="update_password_password_confirmation" class="password-label">{{ __('Confirm Password') }}</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="password-input"
                autocomplete="new-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-sm text-red-500" />
        </div>

        <div class="password-actions">
            <button type="submit" class="password-save">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
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
