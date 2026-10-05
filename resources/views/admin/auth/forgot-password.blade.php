@component('layouts.admin-guest', ['title' => 'Mot de passe oublié'])
    <form method="POST" action="{{ route('admin.password.email') }}" class="flex flex-col gap-5">
        @csrf
        <div>
            <h1 class="mb-2 font-display text-[36px] leading-tight font-extrabold tracking-display">Mot de passe oublié</h1>
            <p class="text-muted">Indiquez votre adresse e-mail : vous recevrez un lien valable 60 minutes pour choisir un nouveau mot de passe.</p>
        </div>

        @if (session('status'))
            <p role="status" class="rounded-xl bg-lime-soft p-4 text-[15px] font-semibold text-success">{{ session('status') }}</p>
        @endif

        <div class="flex flex-col gap-2">
            <label for="email" class="text-[15px] font-semibold">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="field-input bg-white">
            @error('email')<p class="text-sm text-danger">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn btn-ink w-full">Envoyer le lien</button>
        <a href="{{ route('admin.login') }}" class="text-sm text-muted hover:text-violet">← Retour à la connexion</a>
    </form>
@endcomponent
