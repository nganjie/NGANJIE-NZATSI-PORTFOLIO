<x-layouts.site :json-ld="$jsonLd">
    <x-slot:decor>
        <div aria-hidden="true" class="pointer-events-none absolute -top-56 -right-44 size-[420px] rounded-full bg-lime md:size-[560px]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute top-[330px] -right-32 hidden h-[150px] w-[380px] -rotate-[28deg] rounded-full bg-violet md:block"></div>
    </x-slot:decor>

    @include('site.home.hero')

    @if (in_array('projects', $siteSections, true) && $featuredProjects->isNotEmpty())
        @include('site.home.projects')
    @endif

    @if (in_array('skills', $siteSections, true) && $skillDomains->isNotEmpty())
        @include('site.home.skills')
    @endif

    @if (in_array('experience', $siteSections, true) && $experiences->isNotEmpty())
        @include('site.home.experience')
    @endif

    @if (in_array('technologies', $siteSections, true) && $technologies->isNotEmpty())
        @include('site.home.technologies')
    @endif

    @if (in_array('process', $siteSections, true) && $processSteps->isNotEmpty())
        @include('site.home.process')
    @endif

    @if (in_array('contact', $siteSections, true))
        @include('site.home.contact')
    @endif
</x-layouts.site>
