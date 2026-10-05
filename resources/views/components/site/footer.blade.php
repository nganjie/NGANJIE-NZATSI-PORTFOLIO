@props(['profile', 'sections'])

<footer class="bg-coal pt-16 pb-10 text-faint-dark md:pt-20">
    <div class="wrap">
        <div class="flex flex-wrap justify-between gap-10 border-b border-line-dark pb-12">
            <div class="max-w-sm">
                <x-site.logo dark />
                <p class="mt-4 text-[15px] text-muted-dark">{{ $profile->headline }} — {{ $profile->city }}</p>
            </div>

            <nav aria-label="Pied de page">
                <p class="eyebrow mb-4 text-muted-dark">Navigation</p>
                <ul class="flex flex-col gap-2 text-[15px]">
                    <li><a href="{{ route('projects.index') }}" class="text-faint-dark hover:text-lime">Tous les projets</a></li>
                    @foreach (['skills' => ['Compétences', 'competences'], 'experience' => ['Parcours', 'parcours'], 'process' => ['Méthode', 'methode'], 'contact' => ['Contact', 'contact']] as $key => [$label, $anchor])
                        @if (in_array($key, $sections, true))
                            <li><a href="{{ route('home') }}#{{ $anchor }}" class="text-faint-dark hover:text-lime">{{ $label }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </nav>

            <div>
                <p class="eyebrow mb-4 text-muted-dark">Me retrouver</p>
                <ul class="flex flex-col gap-2 text-[15px]">
                    <li><a href="mailto:{{ $profile->email }}" class="text-faint-dark hover:text-lime">{{ $profile->email }}</a></li>
                    @if ($profile->github_url)
                        <li><a href="{{ $profile->github_url }}" rel="me noopener" target="_blank" class="text-faint-dark hover:text-lime">GitHub</a></li>
                    @endif
                    @if ($profile->linkedin_url)
                        <li><a href="{{ $profile->linkedin_url }}" rel="me noopener" target="_blank" class="text-faint-dark hover:text-lime">LinkedIn</a></li>
                    @endif
                    @if ($profile->whatsappUrl())
                        <li><a href="{{ $profile->whatsappUrl() }}" rel="noopener" target="_blank" class="text-faint-dark hover:text-lime">WhatsApp</a></li>
                    @endif
                    @if ($profile->hasCv())
                        <li><a href="{{ route('cv.download') }}" class="text-lime hover:underline">Télécharger le CV (PDF)</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="flex flex-wrap justify-between gap-4 pt-7 text-sm text-muted-dark">
            <span>© {{ now()->year }} {{ $profile->display_name }} — {{ $profile->city }}</span>
            <a href="{{ route('admin.login') }}" class="text-[#8e8d97] hover:text-white">Administration</a>
        </div>
    </div>
</footer>
