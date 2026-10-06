@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'jsonLd' => null,
    'noindex' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.add('js');setTimeout(function(){if(!window.motionReady){document.documentElement.classList.remove('js')}},3000)</script>
    <x-site.seo :title="$title" :description="$description" :image="$image" :type="$type" :json-ld="$jsonLd" :noindex="$noindex" />
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="theme-color" content="#FAFAF7">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="#contenu" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-full focus:bg-ink focus:px-5 focus:py-3 focus:text-white">{{ __('Aller au contenu') }}</a>

    <div class="relative overflow-x-clip">
        {{ $decor ?? '' }}

        <x-site.header :profile="$siteProfile" :sections="$siteSections" />

        <main id="contenu" class="relative">
            {{ $slot }}
        </main>
    </div>

    <x-site.footer :profile="$siteProfile" :sections="$siteSections" />
</body>
</html>
