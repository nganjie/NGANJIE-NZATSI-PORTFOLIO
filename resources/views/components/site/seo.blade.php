@props(['title' => null, 'description' => null, 'image' => null, 'type' => 'website', 'jsonLd' => null, 'noindex' => false])

@php
    $defaultTitle = \App\Support\Settings::localized('seo.default_title');
    $fullTitle = $title ? $title.' — '.$siteProfile->display_name : $defaultTitle;
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($description ?: \App\Support\Settings::localized('seo.default_description')), 160);
    $shareImage = $image ?: $siteProfile->getFirstMediaUrl('share_image', 'og') ?: null;
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<link rel="canonical" href="{{ url()->current() }}">
@unless ($noindex)
    @foreach (\App\Support\Localization::alternates() as $code => $alternateUrl)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ $alternateUrl }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ \App\Support\Localization::alternates()[\App\Support\Localization::DEFAULT] }}">
@endunless
@if ($noindex)
    <meta name="robots" content="noindex, nofollow">
@endif

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteProfile->display_name }}">
<meta property="og:locale" content="{{ \App\Support\Localization::LOCALES[\App\Support\Localization::current()]['og'] }}">
@foreach (\App\Support\Localization::LOCALES as $code => $locale)
    @if ($code !== \App\Support\Localization::current())
        <meta property="og:locale:alternate" content="{{ $locale['og'] }}">
    @endif
@endforeach
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
@if ($shareImage)
    <meta property="og:image" content="{{ $shareImage }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
@endif
<meta name="twitter:card" content="{{ $shareImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">

@if ($jsonLd)
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endif
