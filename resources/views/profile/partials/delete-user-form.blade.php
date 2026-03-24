<section class="space-y-6">
    <header>
        <h2 style="font-size:1.2rem; font-weight:700; color:var(--app-danger-text); letter-spacing:-0.02em;">
            {{ __('Delete Account') }}
        </h2>

        <p style="margin-top:8px; font-size:0.95rem; line-height:1.7; color:var(--app-danger-text); max-width:64ch; opacity:0.88;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently removed. Please make sure you no longer need access before continuing.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-2xl border-0 px-5 py-3 text-sm font-semibold tracking-[0.12em] uppercase"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6" style="font-family:'Inter', sans-serif; background:var(--app-surface-strong);">
            @csrf
            @method('delete')

            <h2 style="font-size:1.2rem; font-weight:700; color:var(--app-text); letter-spacing:-0.02em;">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p style="margin-top:10px; font-size:0.94rem; line-height:1.7; color:var(--app-text-soft);">
                {{ __('This action cannot be undone. Enter your password to confirm permanent deletion of your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-[var(--app-border)] bg-[var(--app-surface-strong)] px-4 py-3.5 text-[var(--app-text)] shadow-none focus:border-red-400 focus:ring-red-400 sm:w-full"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-red-500" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-2xl px-4 py-3 text-sm font-semibold normal-case tracking-normal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="rounded-2xl border-0 px-4 py-3 text-sm font-semibold tracking-[0.12em] uppercase">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
