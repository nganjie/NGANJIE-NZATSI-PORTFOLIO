<section class="bg-ink py-24 text-white md:py-28" aria-labelledby="titre-technologies">
    <div class="wrap">
        <div class="mb-14 flex flex-wrap items-end justify-between gap-6">
            <x-site.section-heading eyebrow="Technologies" number="04" dark heading-id="titre-technologies">
                Mes outils
            </x-site.section-heading>
            <p class="max-w-sm text-muted-dark">Les technologies que j'utilise au quotidien, en production.</p>
        </div>

        <ul class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-line-dark bg-line-dark lg:grid-cols-4">
            @foreach ($technologies as $technology)
                <li class="flex flex-col gap-1.5 bg-ink px-6 py-8 md:px-7">
                    <span class="font-display text-xl font-bold md:text-2xl">{{ $technology->name }}</span>
                    <span class="text-sm text-muted-dark">{{ $technology->category }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</section>
