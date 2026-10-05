<x-layouts.site title="Projets" description="Applications professionnelles en production, projets fintech, personnels et académiques de {{ $siteProfile->display_name }}.">
    <section class="wrap relative pt-10 pb-12 md:pt-16 md:pb-14">
        <div aria-hidden="true" class="pointer-events-none absolute top-10 right-6 hidden h-[84px] w-[220px] -rotate-[14deg] rounded-full bg-lime md:block"></div>
        <nav aria-label="Fil d'Ariane" class="mb-4 text-[15px] text-muted">
            <a href="{{ route('home') }}" class="text-muted hover:text-violet">Accueil</a> <span aria-hidden="true">/</span> <span aria-current="page">Projets</span>
        </nav>
        <h1 class="display relative text-[clamp(3rem,9vw,6rem)]">Tous mes projets</h1>
        <p class="mt-6 max-w-xl text-lg text-muted md:text-[19px]">Applications en production, plateformes fintech et projets personnels : {{ $total }} {{ \Illuminate\Support\Str::plural('projet', $total) }} publiés.</p>
    </section>

    <section class="wrap pb-28" aria-label="Liste des projets">
        @if ($filters->count() > 1)
            <nav aria-label="Filtrer par type" class="mb-10 border-b border-line pb-8">
                <ul class="flex flex-wrap gap-2.5">
                    <li>
                        <a href="{{ route('projects.index') }}" @if (! $activeType) aria-current="page" @endif
                            @class(['inline-flex min-h-11 items-center gap-1.5 rounded-full border px-5 font-display text-[13px] font-bold uppercase tracking-label no-underline',
                                'border-ink bg-ink text-white' => ! $activeType, 'border-line bg-paper text-ink hover:border-ink' => $activeType])>
                            Tous <span class="opacity-60">{{ $total }}</span>
                        </a>
                    </li>
                    @foreach ($filters as $filter)
                        @php($isActive = $activeType === $filter['type'])
                        <li>
                            <a href="{{ route('projects.index', ['type' => $filter['type']->slug()]) }}" @if ($isActive) aria-current="page" @endif
                                @class(['inline-flex min-h-11 items-center gap-1.5 rounded-full border px-5 font-display text-[13px] font-bold uppercase tracking-label no-underline',
                                    'border-ink bg-ink text-white' => $isActive, 'border-line bg-paper text-ink hover:border-ink' => ! $isActive])>
                                {{ $filter['type']->label() }} <span class="opacity-60">{{ $filter['count'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($projects->isEmpty())
            <p class="rounded-2xl bg-mist p-8 text-muted">Aucun projet dans cette catégorie pour le moment.</p>
        @else
            <ul class="grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <li>
                        <a href="{{ route('projects.show', $project) }}" class="lift group flex flex-col gap-4 text-ink no-underline">
                            <x-site.project-media :project="$project" class="h-64" sizes="(min-width: 1024px) 380px, (min-width: 640px) 50vw, 100vw" />
                            <div class="flex flex-wrap gap-2">
                                <span class="eyebrow rounded-full bg-mist px-3 py-1 text-xs">{{ $project->type->label() }}</span>
                                @foreach ($project->tagList() as $tag)
                                    <span class="eyebrow rounded-full border border-line px-3 py-1 text-xs text-muted">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <h2 class="font-display text-[26px] leading-[1.15] font-bold tracking-[-0.02em] group-hover:text-violet">{{ $project->title }}</h2>
                            <p class="text-base text-muted">{{ $project->summary }}</p>
                            @if ($project->technologies->isNotEmpty())
                                <p class="text-[15px] font-semibold">{{ $project->stackLabel() }}</p>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-layouts.site>
