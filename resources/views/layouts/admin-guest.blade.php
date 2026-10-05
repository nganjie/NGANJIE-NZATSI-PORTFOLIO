<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Connexion' }} — Administration</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="flex min-h-screen flex-wrap">
        <div class="relative flex min-h-[300px] flex-[1_1_480px] flex-col justify-between overflow-hidden bg-ink p-8 text-white md:p-14">
            <div aria-hidden="true" class="absolute -right-40 -bottom-48 size-[460px] rounded-full bg-lime"></div>
            <div aria-hidden="true" class="absolute right-28 bottom-48 h-[110px] w-[300px] -rotate-[24deg] rounded-full bg-violet"></div>
            <x-site.logo dark class="relative" />
            <div class="relative max-w-md">
                <p class="eyebrow mb-3 text-lime">Administration</p>
                <p class="display text-[clamp(2.5rem,5vw,3.5rem)] leading-[0.98]">Gérez votre portfolio</p>
            </div>
        </div>

        <main class="flex flex-[1_1_480px] items-center justify-center px-6 py-14">
            <div class="w-full max-w-[420px]">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
