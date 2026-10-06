@props(['profile', 'sections'])

@php
    $links = collect([
        'projects' => ['Projets', route('home').'#projets'],
        'skills' => ['Compétences', route('home').'#competences'],
        'experience' => ['Parcours', route('home').'#parcours'],
        'process' => ['Méthode', route('home').'#methode'],
        'contact' => ['Contact', route('home').'#contact'],
    ])->only($sections);
@endphp

<header class="site-header sticky top-0 z-40">
    <div class="wrap flex items-center justify-between gap-6 py-5 md:py-7">
        <x-site.logo />

        <nav aria-label="Navigation principale" class="hidden lg:block">
            <ul class="flex flex-wrap gap-2">
                @foreach ($links as $key => [$label, $href])
                    <li>
                        <a href="{{ $href }}" @class(['nav-pill', 'bg-lime!' => $key === 'projects' && request()->routeIs('projects.*')])>{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex items-center gap-3">
            <a href="mailto:{{ $profile->email }}" class="hidden rounded-full bg-violet px-5 py-3 text-[15px] font-semibold text-white no-underline transition-colors hover:bg-ink sm:inline-block">{{ $profile->email }}</a>

            <button type="button" data-menu-toggle aria-expanded="false" aria-controls="menu-mobile" aria-label="Ouvrir le menu"
                class="grid size-12 place-items-center rounded-full bg-ink text-white lg:hidden">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h10"/></svg>
            </button>
        </div>
    </div>

    <nav id="menu-mobile" aria-label="Menu" hidden class="absolute inset-x-4 top-[84px] z-30 rounded-[20px] bg-ink p-4 shadow-2xl lg:hidden">
        <ul class="flex flex-col gap-1.5">
            @foreach ($links as $key => [$label, $href])
                <li>
                    <a href="{{ $href }}" @class([
                        'block rounded-xl px-4 py-3.5 font-semibold no-underline',
                        'bg-lime text-ink' => $key === 'contact',
                        'bg-line-dark text-white hover:bg-[#3a3a42]' => $key !== 'contact',
                    ])>{{ $label }}</a>
                </li>
            @endforeach
            <li>
                <a href="mailto:{{ $profile->email }}" class="block rounded-xl bg-violet px-4 py-3.5 font-semibold text-white no-underline">{{ $profile->email }}</a>
            </li>
        </ul>
    </nav>
</header>
