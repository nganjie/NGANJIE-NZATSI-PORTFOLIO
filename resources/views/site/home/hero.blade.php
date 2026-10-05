@php
    $featured = $profile->featuredProject;
    $photo = $profile->getFirstMedia('photo');
@endphp

<section class="relative pb-20 md:pb-28" aria-labelledby="titre-accueil">
    <div class="wrap relative pt-6 md:pt-12">
        <div class="flex flex-col-reverse items-start justify-between gap-8 md:flex-row md:items-center md:gap-8">
            <h1 id="titre-accueil" class="display max-w-[800px] text-[clamp(2.75rem,6.6vw,5.6rem)]">
                {{ $profile->tagline }}
                @if ($profile->tagline_highlight)
                    <span class="highlight mt-2">{{ $profile->tagline_highlight }}</span>
                @endif
            </h1>

            <div class="relative grid size-36 shrink-0 place-items-center overflow-hidden rounded-full border-[6px] border-paper bg-lilac md:size-56 lg:size-[300px]">
                @if ($photo)
                    <x-site.image :media="$photo" :conversions="['sm' => 300, 'md' => 600]" sizes="(min-width: 768px) 300px, 144px" eager
                        :alt="'Photo de '.$profile->display_name" class="size-full object-cover" />
                @else
                    <span aria-hidden="true" class="display text-5xl text-violet md:text-8xl">{{ \Illuminate\Support\Str::of($profile->display_name)->explode(' ')->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->join('') }}</span>
                @endif
            </div>
        </div>

        <div class="mt-14 grid items-center gap-10 md:mt-[72px] md:grid-cols-2 md:gap-12 [&>*]:min-w-0">
            @if ($featured)
                <a href="{{ route('projects.show', $featured) }}" class="lift group block rounded-2xl border-t-[6px] border-lime bg-ink px-6 pt-6 no-underline md:px-10 md:pt-10">
                    <div class="eyebrow mb-5 flex justify-between gap-4 text-muted-dark">
                        <span>Projet phare</span>
                        <span class="text-lime">{{ $featured->title }} ↗</span>
                    </div>
                    <x-site.project-media :project="$featured" class="h-56 rounded-b-none md:h-64" sizes="(min-width: 768px) 520px, 100vw" />
                </a>
            @endif

            <div @class(['md:col-span-2' => ! $featured])>
                @if ($profile->is_available && $profile->availability_label)
                    <p class="eyebrow mb-5 flex items-center gap-2.5 text-sm">
                        <span aria-hidden="true" class="size-2.5 rounded-full bg-[#3fa60a] ring-4 ring-lime-soft"></span>
                        {{ $profile->availability_label }}
                    </p>
                @endif

                <p class="mb-8 text-lg leading-normal text-[#2a2a30] md:text-[21px]">{{ $profile->bio }}</p>

                <div class="flex flex-wrap gap-3">
                    @if (in_array('projects', $siteSections, true))
                        <a href="#projets" class="btn btn-lime">Découvrir mes projets</a>
                    @endif
                    <a href="{{ in_array('contact', $siteSections, true) ? '#contact' : 'mailto:'.$profile->email }}" class="btn btn-ink">Me recruter</a>
                </div>

                <div class="mt-9 flex flex-wrap items-center justify-between gap-5">
                    <ul class="flex flex-wrap gap-6" aria-label="Réseaux">
                        @if ($profile->github_url)
                            <li><a href="{{ $profile->github_url }}" class="link-underline" target="_blank" rel="me noopener">GitHub ↗</a></li>
                        @endif
                        @if ($profile->linkedin_url)
                            <li><a href="{{ $profile->linkedin_url }}" class="link-underline" target="_blank" rel="me noopener">LinkedIn ↗</a></li>
                        @endif
                        @if ($profile->whatsappUrl())
                            <li><a href="{{ $profile->whatsappUrl() }}" class="link-underline" target="_blank" rel="noopener">WhatsApp ↗</a></li>
                        @endif
                    </ul>
                    @if ($profile->hasCv())
                        <a href="{{ route('cv.download') }}" class="link-underline">Télécharger le CV (PDF) ↓</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
