<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ isset($title) ? $title.' — ' : '' }}Administration</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @livewireStyles
</head>
<body class="bg-paper text-base">
    <a href="#contenu" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-full focus:bg-lime focus:px-5 focus:py-3">Aller au contenu</a>

    <div class="flex min-h-screen flex-wrap">
        <aside class="flex w-full flex-col gap-1 bg-ink px-4 py-6 lg:sticky lg:top-0 lg:h-screen lg:w-[272px] lg:shrink-0 lg:overflow-y-auto lg:py-7" x-data="{ open: false }">
            <div class="flex items-center justify-between px-3.5 lg:pb-7">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 text-white no-underline">
                    <span aria-hidden="true" class="size-[26px] -rotate-8 rounded-lg bg-violet"></span>
                    <span class="font-display text-[22px] font-extrabold tracking-display">nganjie<span class="text-lime">.</span></span>
                </a>
                <button type="button" class="grid size-11 place-items-center rounded-full bg-line-dark text-white lg:hidden" x-on:click="open = ! open"
                    x-bind:aria-expanded="open.toString()" aria-controls="admin-nav" aria-label="Menu de l'administration">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h10"/></svg>
                </button>
            </div>

            <div id="admin-nav" class="mt-4 hidden flex-1 flex-col gap-1 lg:mt-0 lg:flex" x-bind:class="{ 'flex!': open }">
                <nav aria-label="Administration">
                    <ul class="flex flex-col gap-1">
                        <x-admin.nav-item route="admin.dashboard">Tableau de bord</x-admin.nav-item>
                        <x-admin.nav-item route="admin.profile">Profil et CV</x-admin.nav-item>
                        <x-admin.nav-item route="admin.projects.index" active="admin.projects.*">Projets</x-admin.nav-item>
                        <x-admin.nav-item route="admin.skills">Compétences</x-admin.nav-item>
                        <x-admin.nav-item route="admin.technologies">Technologies</x-admin.nav-item>
                        <x-admin.nav-item route="admin.experiences">Parcours</x-admin.nav-item>
                        <x-admin.nav-item route="admin.process">Méthode</x-admin.nav-item>
                        <x-admin.nav-item route="admin.messages" :badge="$unreadMessages">Messages</x-admin.nav-item>
                        <x-admin.nav-item route="admin.media">Médias</x-admin.nav-item>
                        <x-admin.nav-item route="admin.settings">Paramètres</x-admin.nav-item>
                    </ul>
                </nav>

                <div class="mt-6 flex flex-col gap-2 border-t border-line-dark px-3.5 pt-5 text-sm lg:mt-auto">
                    <a href="{{ route('home') }}" target="_blank" class="text-faint-dark hover:text-lime">Voir le site ↗</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="cursor-pointer text-muted-dark hover:text-white">Se déconnecter</button>
                    </form>
                </div>
            </div>
        </aside>

        <main id="contenu" class="min-w-0 flex-1 px-4 py-8 sm:px-8 lg:px-12 lg:py-10">
            <x-admin.flash />
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
