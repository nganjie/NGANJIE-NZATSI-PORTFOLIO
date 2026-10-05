@component('layouts.admin-guest', ['title' => 'Nouveau mot de passe'])
    <form method="POST" action="{{ route('admin.password.update') }}" class="flex flex-col gap-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <h1 class="font-display text-[36px] leading-tight font-extrabold tracking-display">Nouveau mot de passe</h1>

        <div class="flex flex-col gap-2">
            <label for="email" class="text-[15px] font-semibold">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="username" class="field-input bg-white">
            @error('email')<p class="text-sm text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="password" class="text-[15px] font-semibold">Nouveau mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="field-input bg-white" aria-describedby="password-help">
            <p id="password-help" class="text-sm text-muted">12 caractères minimum, avec des lettres et des chiffres.</p>
            @error('password')<p class="text-sm text-danger">{{ $message }}</p>@enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="password_confirmation" class="text-[15px] font-semibold">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="field-input bg-white">
        </div>

        <button type="submit" class="btn btn-ink w-full">Enregistrer</button>
    </form>
@endcomponent
