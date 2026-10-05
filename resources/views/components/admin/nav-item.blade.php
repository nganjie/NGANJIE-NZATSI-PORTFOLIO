@props(['route', 'active' => null, 'badge' => 0])

@php($isActive = request()->routeIs($active ?? $route))

<li>
    <a href="{{ route($route) }}" wire:navigate @if ($isActive) aria-current="page" @endif
        @class([
            'flex min-h-11 items-center gap-3 rounded-xl px-3.5 text-[15px] no-underline transition-colors',
            'bg-lime font-semibold text-ink' => $isActive,
            'font-medium text-faint-dark hover:bg-line-dark hover:text-white' => ! $isActive,
        ])>
        {{ $slot }}
        @if ($badge > 0)
            <span @class(['ml-auto rounded-full px-2.5 text-[13px]', 'bg-ink text-white' => $isActive, 'bg-violet text-white' => ! $isActive])>
                {{ $badge }}<span class="sr-only"> non lus</span>
            </span>
        @endif
    </a>
</li>
