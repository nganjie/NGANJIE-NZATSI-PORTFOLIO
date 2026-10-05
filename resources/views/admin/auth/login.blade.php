@component('layouts.admin-guest', ['title' => 'Connexion'])
    <form method="POST" action="{{ route('admin.login.store') }}" class="flex flex-col gap-5">
        @csrf
        <div>
            <h1 class="mb-2 font-display text-[40px] font-extrabold tracking-display">Connexion</h1>
            <p class="text-muted">Accès réservé au propriétaire du site.</p>
        </div>

        @if (session('status'))
            <p role="status" class="rounded-xl bg-lime-soft p-4 text-[15px] font-semibold text-success">{{ session('status') }}</p>
        @endif

        <div class="flex flex-col gap-2">
            <label for="email" class="text-[15px] font-semibold">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="field-input bg-white"
                @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
            @error('email')<p id="email-error" class="text-sm text-danger">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex items-baseline justify-between gap-4">
                <label for="password" class="text-[15px] font-semibold">Mot de passe</label>
                <a href="{{ route('admin.password.request') }}" class="text-sm font-semibold text-violet hover:underline">Mot de passe oublié ?</a>
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="field-input bg-white"
                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            @error('password')<p id="password-error" class="text-sm text-danger">{{ $message }}</p>@enderror
        </div>

        <label class="flex min-h-11 cursor-pointer items-center gap-2.5 text-[15px]">
            <input type="checkbox" name="remember" value="1" class="size-5 accent-violet" @checked(old('remember'))>
            Rester connecté
        </label>

        <button type="submit" class="btn btn-ink w-full">Se connecter</button>

        <p class="rounded-xl bg-mist px-4 py-3.5 text-sm text-muted">Après {{ \App\Http\Controllers\Admin\AuthController::MAX_ATTEMPTS }} tentatives échouées, la connexion est bloquée pendant 15 minutes.</p>
        <a href="{{ route('home') }}" class="text-sm text-muted hover:text-violet">← Retour au site</a>
    </form>
@endcomponent
