@php($rotations = ['-rotate-[1.5deg]', 'rotate-1', '-rotate-1', 'rotate-[1.5deg]'])

<section id="methode" class="scroll-mt-6 py-24 md:py-28" aria-labelledby="titre-methode">
    <div class="wrap">
        <x-site.section-heading :eyebrow="__('Méthode')" number="05" heading-id="titre-methode" class="mb-14 md:mb-16">
            {{ __('Comment je travaille') }}
        </x-site.section-heading>

        <ol data-reveal-group="130" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($processSteps as $step)
                <li data-reveal="drop" @class(['lift rounded-2xl border border-ink bg-white p-7 motion-reduce:rotate-0', $rotations[$loop->index % 4]])>
                    <span class="grid size-11 place-items-center rounded-full bg-lime font-display font-extrabold" aria-hidden="true">{{ $loop->iteration }}</span>
                    <h3 class="mt-5 mb-2.5 font-display text-[26px] font-bold"><span class="sr-only">{{ __('Étape :number :', ['number' => $loop->iteration]) }} </span>{{ $step->title }}</h3>
                    <p class="text-base text-muted">{{ $step->body }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
