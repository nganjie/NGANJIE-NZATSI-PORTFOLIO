<x-layouts.site :title="__('Page introuvable')" noindex>
    <section class="wrap relative py-24 md:py-32">
        <div aria-hidden="true" class="pointer-events-none absolute top-16 right-6 hidden size-48 rounded-full bg-lime md:block"></div>
        <p class="eyebrow mb-4 text-violet">{{ __('Erreur 404') }}</p>
        <h1 class="display relative max-w-3xl text-[clamp(2.75rem,8vw,6rem)]">{{ __('Cette page') }} <span class="highlight">{{ __('n\'existe pas') }}</span></h1>
        <p class="mt-8 max-w-xl text-lg text-muted">{{ __('Le lien est peut-être ancien, ou le projet n\'est plus publié. Vous pouvez revenir à l\'accueil ou parcourir tous les projets.') }}</p>
        <div class="mt-10 flex flex-wrap gap-3">
            <a href="{{ localized_route('home') }}" class="btn btn-lime">{{ __('Retour à l\'accueil') }}</a>
            <a href="{{ localized_route('projects.index') }}" class="btn btn-ink">{{ __('Voir les projets') }}</a>
        </div>
    </section>
</x-layouts.site>
