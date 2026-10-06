<section id="projets" class="scroll-mt-6 py-20 md:py-24" aria-labelledby="titre-projets">
    <div class="wrap">
        <div class="mb-12 flex flex-wrap items-end justify-between gap-6 md:mb-16">
            <x-site.section-heading eyebrow="Projets" number="01" heading-id="titre-projets">
                Dans les coulisses<br class="hidden sm:inline"> de mes projets
            </x-site.section-heading>
            <a href="{{ route('projects.index') }}" data-reveal class="btn btn-lime">Voir tous les projets</a>
        </div>

        <ul class="flex flex-col">
            @foreach ($featuredProjects as $project)
                <li>
                    <a href="{{ route('projects.show', $project) }}" class="group grid items-center gap-8 border-t border-line py-8 text-ink no-underline md:grid-cols-2 md:gap-12">
                        <div data-reveal>
                            <p class="eyebrow mb-2.5 text-muted">{{ $project->type->label() }}@if ($project->tagList()) · {{ implode(' · ', $project->tagList()) }}@endif</p>
                            <h3 class="mb-6 font-display text-[28px] leading-[1.1] font-bold tracking-[-0.02em] group-hover:text-violet md:text-[34px]">{{ $project->title }}</h3>
                            <dl class="grid grid-cols-[96px_minmax(0,1fr)] gap-x-4 gap-y-2.5 text-base">
                                @if ($project->context)
                                    <dt class="text-muted">Contexte</dt><dd class="font-semibold">{{ $project->context }}</dd>
                                @endif
                                @if ($project->role)
                                    <dt class="text-muted">Mon rôle</dt><dd class="font-semibold">{{ $project->role }}</dd>
                                @endif
                                @if ($project->technologies->isNotEmpty())
                                    <dt class="text-muted">Stack</dt><dd class="font-semibold">{{ $project->stackLabel() }}</dd>
                                @endif
                            </dl>
                            <span class="mt-6 inline-block border-b-2 border-ink font-display text-[13px] font-bold tracking-label uppercase">Lire l'étude de cas →</span>
                        </div>
                        <x-site.project-media :project="$project" data-reveal="wipe" class="lift h-64 md:h-[360px]" />
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>
