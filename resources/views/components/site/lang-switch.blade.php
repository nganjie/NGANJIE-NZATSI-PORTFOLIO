@props(['dark' => false])

@php($current = \App\Support\Localization::current())

<nav aria-label="{{ __('Choisir la langue') }}" {{ $attributes->class(['inline-flex rounded-full p-1', 'bg-line-dark' => $dark, 'bg-mist' => ! $dark]) }}>
    <ul class="flex gap-1">
        @foreach (\App\Support\Localization::LOCALES as $code => $locale)
            <li>
                @if ($code === $current)
                    <span aria-current="true" title="{{ $locale['name'] }}"
                        @class(['inline-flex h-9 min-w-11 items-center justify-center rounded-full px-3 leading-none font-display text-[13px] font-bold tracking-label', 'bg-lime text-ink' => $dark, 'bg-ink text-white' => ! $dark])>
                        {{ $locale['native'] }}<span class="sr-only"> — {{ $locale['name'] }}</span>
                    </span>
                @else
                    <a href="{{ \App\Support\Localization::switchUrl($code) }}" hreflang="{{ $code }}" lang="{{ $code }}" title="{{ $locale['name'] }}"
                        @class(['inline-flex h-9 min-w-11 items-center justify-center rounded-full px-3 leading-none font-display text-[13px] font-bold tracking-label no-underline transition-colors', 'text-faint-dark hover:bg-ink hover:text-lime' => $dark, 'text-ink hover:bg-lime' => ! $dark])>
                        {{ $locale['native'] }}<span class="sr-only"> — {{ $locale['name'] }}</span>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
