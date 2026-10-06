<x-layouts.site :title="$project->seo_title ?: $project->title" :description="$project->seo_description ?: $project->summary" :image="$shareImage" type="article" :json-ld="$jsonLd" :noindex="$isPreview">
    @if ($isPreview)
        <div role="status" class="bg-lilac py-3 text-center text-sm font-semibold text-[#2a1466]">
            {{ __('Aperçu : ce projet est un brouillon, il n\'est pas visible par le public.') }}
            <a href="{{ route('admin.projects.edit', $project) }}" class="ml-2 underline">{{ __('Modifier') }}</a>
        </div>
    @endif

    <div data-progress class="scroll-progress" aria-hidden="true"></div>

    <article>
        <header class="wrap pt-10 pb-12 md:pt-14 md:pb-14">
            <nav aria-label="{{ __('Fil d\'Ariane') }}" class="mb-6 text-[15px] text-muted">
                <a href="{{ localized_route('home') }}" class="text-muted hover:text-violet">{{ __('Accueil') }}</a> <span aria-hidden="true">/</span>
                <a href="{{ localized_route('projects.index') }}" class="text-muted hover:text-violet">{{ __('Projets') }}</a> <span aria-hidden="true">/</span>
                <span aria-current="page">{{ $project->title }}</span>
            </nav>

            <ul data-reveal-group="80" class="mb-6 flex flex-wrap gap-2" aria-label="{{ __('Catégories') }}">
                <li data-reveal="pop" class="eyebrow rounded-full bg-violet px-3.5 py-1.5 text-xs text-white">{{ $project->type->label() }}</li>
                @foreach ($project->tagList() as $tag)
                    <li data-reveal="pop" class="eyebrow rounded-full bg-mist px-3.5 py-1.5 text-xs">{{ $tag }}</li>
                @endforeach
            </ul>

            <div class="flex flex-wrap items-end justify-between gap-8">
                <div class="max-w-[820px]">
                    <h1 data-split class="display mb-6 text-[clamp(2.75rem,8vw,6rem)] break-words">{{ $project->title }}</h1>
                    <p data-reveal style="--reveal-delay: 300ms" class="text-lg leading-normal text-[#2a2a30] md:text-[21px]">{{ $project->summary }}</p>
                </div>
                <div data-reveal style="--reveal-delay: 450ms" class="flex flex-wrap gap-3">
                    @if ($project->demo_url)
                        <a href="{{ $project->demo_url }}" class="btn btn-ink" target="_blank" rel="noopener">{{ __('Voir le site en ligne') }} ↗</a>
                    @endif
                    @if ($project->repository_url)
                        <a href="{{ $project->repository_url }}" class="btn btn-mist" target="_blank" rel="noopener">{{ __('Code source') }} ↗</a>
                    @endif
                </div>
            </div>
        </header>

        <div class="wrap">
            <x-site.project-media :project="$project" data-reveal="wipe" class="h-[300px] md:h-[600px]" sizes="(min-width: 1180px) 1132px, 100vw" eager />

            <dl data-reveal-group="100" class="grid grid-cols-1 gap-4 pt-10 pb-20 sm:grid-cols-2 lg:grid-cols-4 md:pb-24">
                @if ($project->role)<x-site.fact :label="__('Rôle')">{{ $project->role }}</x-site.fact>@endif
                @if ($project->context)<x-site.fact :label="__('Contexte')">{{ $project->context }}</x-site.fact>@endif
                @if ($project->technologies->isNotEmpty())<x-site.fact label="Stack">{{ $project->stackLabel() }}</x-site.fact>@endif
                @if ($project->period)<x-site.fact :label="__('Période')">{{ $project->period }}</x-site.fact>@endif
            </dl>
        </div>

        @if ($project->case_study)
            <section class="mx-auto max-w-[820px] px-4 pb-24 sm:px-6" aria-labelledby="titre-contexte">
                <p data-reveal class="eyebrow mb-3 text-violet">{{ __('Le contexte') }}</p>
                <h2 id="titre-contexte" data-split class="display mb-8 text-[clamp(2rem,5vw,3rem)] leading-none">{{ __('Le projet en détail') }}</h2>
                <div data-reveal class="prose-case">{!! \App\Support\RichText::sanitize($project->case_study) !!}</div>
            </section>
        @endif

        @if ($project->tasks->isNotEmpty())
            <section class="bg-ink py-24 text-white md:py-28" aria-labelledby="titre-realisations">
                <div class="wrap">
                    <p data-reveal class="eyebrow mb-3 text-lime">{{ __('Ce que j\'ai fait') }}</p>
                    <h2 id="titre-realisations" data-split class="display mb-14 text-[clamp(2.25rem,6vw,3.5rem)] leading-none">{{ __('Mes réalisations') }}</h2>
                    <ol data-reveal-group="120">
                        @foreach ($project->tasks as $task)
                            <li data-reveal class="grid grid-cols-[56px_minmax(0,1fr)] gap-5 border-t border-line-dark py-8 md:grid-cols-[80px_minmax(0,1fr)] md:gap-6">
                                <span data-reveal="pop" class="grid size-12 place-items-center rounded-full bg-lime font-display font-extrabold text-ink" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <div>
                                    <h3 class="mb-2 font-display text-[22px] font-bold md:text-[26px]">{{ $task->title }}</h3>
                                    @if ($task->body)<p class="max-w-3xl text-muted-dark">{{ $task->body }}</p>@endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </section>
        @endif

        @if ($gallery->isNotEmpty())
            <section class="wrap pt-24 pb-20" aria-labelledby="titre-galerie">
                <p data-reveal class="eyebrow mb-3 text-violet">{{ __('Galerie') }}</p>
                <h2 id="titre-galerie" data-split class="display mb-10 text-[clamp(2rem,5vw,3rem)] leading-none">{{ __('En images') }}</h2>
                <div data-reveal-group="140" class="grid gap-6 md:grid-cols-2">
                    @foreach ($gallery as $image)
                        <figure data-reveal="wipe">
                            <div class="rounded-md p-3.5" style="background-color: {{ $project->accent_color->hex() }}">
                                <x-site.image :media="$image" sizes="(min-width: 768px) 560px, 100vw" class="w-full rounded-[3px]" />
                            </div>
                            @php($caption = $image->getCustomProperty('caption.'.app()->getLocale()) ?: $image->getCustomProperty('caption.fr'))
                            @if ($caption)
                                <figcaption class="mt-3 text-[15px] text-muted">{{ $caption }}</figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($project->lesson || $project->resultLines())
            <section class="wrap grid gap-6 pt-10 pb-28 md:grid-cols-2" aria-label="{{ __('Bilan') }}">
                @if ($project->lesson)
                    <blockquote data-reveal="drop" class="-rotate-[1.5deg] rounded-2xl border border-ink bg-white p-8 motion-reduce:rotate-0 md:p-10">
                        <p class="eyebrow mb-4 text-violet">{{ __('Ce que j\'en retiens') }}</p>
                        <p class="font-display text-2xl leading-snug font-bold md:text-[28px]">« {{ $project->lesson }} »</p>
                    </blockquote>
                @endif
                @if ($project->resultLines())
                    <div data-reveal style="--reveal-delay: 150ms" class="rounded-2xl bg-lime p-8 md:p-10">
                        <h2 class="eyebrow mb-4">{{ __('Résultats') }}</h2>
                        <ul class="flex list-disc flex-col gap-2.5 pl-5 text-lg">
                            @foreach ($project->resultLines() as $result)
                                <li>{{ $result }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </section>
        @endif
    </article>

    @if ($next)
        <a href="{{ localized_route('projects.show', $next) }}" class="group block bg-violet py-16 text-white no-underline md:py-20">
            <div class="wrap flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="eyebrow mb-2 text-violet-soft">{{ __('Projet suivant') }}</p>
                    <p data-reveal="right" class="display text-[clamp(2.25rem,6vw,3.5rem)] leading-none">{{ $next->title }}</p>
                </div>
                <span aria-hidden="true" data-reveal="pop" style="--reveal-delay: 250ms" class="grid size-[88px] place-items-center rounded-full bg-lime text-4xl text-ink transition-[translate] duration-300 group-hover:translate-x-2">→</span>
            </div>
        </a>
    @endif
</x-layouts.site>
