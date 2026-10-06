{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@php
    $locales = \App\Support\Localization::codes();
    $pages = [
        ['home', [], 'weekly', '1.0', null],
        ['projects.index', [], 'weekly', '0.8', null],
    ];
    foreach ($projects as $project) {
        $pages[] = ['projects.show', [$project], 'monthly', '0.7', $project->updated_at];
    }
@endphp
@foreach ($pages as [$name, $parameters, $frequency, $priority, $updatedAt])
    @foreach ($locales as $locale)
    <url>
        <loc>{{ localized_route($name, $parameters, $locale) }}</loc>
        @foreach ($locales as $alternate)
        <xhtml:link rel="alternate" hreflang="{{ $alternate }}" href="{{ localized_route($name, $parameters, $alternate) }}"/>
        @endforeach
        @if ($updatedAt)
        <lastmod>{{ $updatedAt->toAtomString() }}</lastmod>
        @endif
        <changefreq>{{ $frequency }}</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
    @endforeach
@endforeach
</urlset>
