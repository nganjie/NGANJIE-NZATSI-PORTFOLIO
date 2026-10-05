@props(['title' => null, 'description' => null, 'image' => null, 'type' => 'website', 'jsonLd' => null, 'noindex' => false])

@php
    $defaultTitle = \App\Support\Settings::get('seo.default_title');
    $fullTitle = $title ? $title.' — '.$siteProfile->display_name : $defaultTitle;
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($description ?: \App\Support\Settings::get('seo.default_description')), 160);
    $shareImage = $image ?: $siteProfile->getFirstMediaUrl('share_image', 'og') ?: null;
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<link rel="canonical" href="{{ url()->current() }}">
@if ($noindex)
    <meta name="robots" content="noindex, nofollow">
@endif

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteProfile->display_name }}">
<meta property="og:locale" content="fr_FR">
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
