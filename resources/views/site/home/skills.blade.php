<section id="competences" class="scroll-mt-6 bg-ink py-24 text-white md:py-28" aria-labelledby="titre-competences">
    <div class="wrap">
        <x-site.section-heading eyebrow="Compétences" number="02" dark heading-id="titre-competences" class="mb-14 max-w-3xl md:mb-16">
            Du serveur à l'écran, de bout en bout
        </x-site.section-heading>

        <ul data-reveal-group="120" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($skillDomains as $domain)
                <li data-reveal class="lift flex flex-col gap-4 rounded-2xl border border-line-dark p-7">
                    <span class="font-display text-[15px] font-extrabold text-lime">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="font-display text-2xl leading-tight font-bold">{{ $domain->title }}</h3>
                    <p class="text-base text-muted-dark">{{ $domain->description }}</p>
                    <ul class="mt-auto flex flex-wrap gap-2 pt-2" aria-label="Outils">
                        @foreach ($domain->tagList() as $tag)
                            <li class="rounded-full border border-line-dark px-3 py-1.5 text-[13px] text-faint-dark">{{ $tag }}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</section>
