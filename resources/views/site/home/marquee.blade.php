@php
    $items = $technologies->pluck('name');
    $words = [__('Applications web'), 'Fintech', 'API REST', __('Temps réel'), 'Back-offices'];
@endphp

<div aria-hidden="true" class="relative -my-4 py-10 select-none md:py-14">
    <div class="marquee absolute inset-x-[-5%] top-1/2 -translate-y-1/2 rotate-[2.5deg] overflow-hidden bg-ink py-3.5 text-white md:py-4">
        <div class="marquee-track is-reverse flex w-max" style="--marquee-duration: 46s">
            @foreach ([false, true] as $duplicate)
                <div class="flex shrink-0 items-center" @if ($duplicate) data-duplicate @endif>
                    @foreach ($words as $word)
                        <span class="flex items-center gap-6 px-6 font-display text-lg font-bold uppercase tracking-label md:text-xl">
                            {{ $word }}<span class="text-violet-soft">◆</span>
                        </span>
                    @endforeach
                    @foreach ($words as $word)
                        <span class="flex items-center gap-6 px-6 font-display text-lg font-bold uppercase tracking-label md:text-xl">
                            {{ $word }}<span class="text-violet-soft">◆</span>
                        </span>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="marquee relative inset-x-[-5%] w-[110%] -rotate-[2deg] overflow-hidden bg-lime py-4 text-ink shadow-[0_18px_40px_-24px_rgb(14_14_16/0.45)] md:py-5">
        <div class="marquee-track flex w-max" style="--marquee-duration: 38s">
            @foreach ([false, true] as $duplicate)
                <div class="flex shrink-0 items-center" @if ($duplicate) data-duplicate @endif>
                    @foreach ([...$items, ...$items] as $item)
                        <span class="flex items-center gap-7 px-7 font-display text-2xl font-extrabold uppercase tracking-display md:text-[34px]">
                            {{ $item }}<svg class="size-5 shrink-0 md:size-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c.6 6.6 5.4 11.4 12 12-6.6.6-11.4 5.4-12 12-.6-6.6-5.4-11.4-12-12C6.6 11.4 11.4 6.6 12 0Z"/></svg>
                        </span>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
