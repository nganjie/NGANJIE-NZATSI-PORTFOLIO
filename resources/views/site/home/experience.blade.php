<section id="parcours" class="scroll-mt-6 py-24 md:py-28" aria-labelledby="titre-parcours">
    <div class="wrap">
        <x-site.section-heading eyebrow="Parcours" number="03" heading-id="titre-parcours" class="mb-12 md:mb-14">
            Mon parcours
        </x-site.section-heading>
    </div>

    <ol>
        @foreach ($experiences as $experience)
            <li data-reveal="{{ $experience->is_current ? 'band' : 'up' }}" @class(['current-band text-white' => $experience->is_current])>
                <div @class([
                    'wrap grid gap-4 py-9 md:grid-cols-[200px_minmax(0,1fr)_minmax(0,1.3fr)] md:gap-8',
                    'border-b border-line' => ! $experience->is_current && ! $loop->last,
                ])>
                    <div>
                        <p class="font-display text-[15px] font-bold">{{ $experience->periodLabel() }}</p>
                        @if ($experience->is_current)
                            <span class="eyebrow mt-2.5 inline-block rounded-full bg-lime px-3 py-1 text-xs text-ink">Poste actuel</span>
                        @elseif ($experience->type === \App\Enums\ExperienceType::Education)
                            <span class="eyebrow mt-2.5 inline-block rounded-full bg-mist px-3 py-1 text-xs text-muted">Formation</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-display text-[22px] leading-tight font-bold md:text-[26px]">{{ $experience->title }}</h3>
                        <p @class(['mt-1.5', 'text-violet-soft' => $experience->is_current, 'text-muted' => ! $experience->is_current])>
                            {{ $experience->organization }}@if ($experience->location) · {{ $experience->location }}@endif
                        </p>
                    </div>
                    @if ($experience->highlightList())
                        <ul @class(['list-disc space-y-1.5 pl-5 text-base', 'text-[#f2edff]' => $experience->is_current, 'text-muted' => ! $experience->is_current])>
                            @foreach ($experience->highlightList() as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</section>
