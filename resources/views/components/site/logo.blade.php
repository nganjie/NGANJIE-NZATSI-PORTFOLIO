@props(['dark' => false])

<a href="{{ route('home') }}" {{ $attributes->class(['flex items-center gap-2.5 no-underline', 'text-white' => $dark, 'text-ink' => ! $dark]) }} aria-label="{{ $siteProfile->display_name }}, accueil">
    <span aria-hidden="true" class="size-8 -rotate-8 rounded-[10px] bg-violet"></span>
    <span class="font-display text-[26px] font-extrabold tracking-display">nganjie<span @class(['text-lime' => $dark, 'text-violet' => ! $dark])>.</span></span>
</a>
