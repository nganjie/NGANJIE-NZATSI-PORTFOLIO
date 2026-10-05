@props(['label', 'checked' => false, 'srOnlyLabel' => false])

<button type="button" role="switch" aria-checked="{{ $checked ? 'true' : 'false' }}"
    @if ($srOnlyLabel) aria-label="{{ $label }}" @endif
    {{ $attributes->class(['group inline-flex min-h-11 cursor-pointer items-center gap-3']) }}>
    <span @class(['relative h-7 w-12 shrink-0 rounded-full transition-colors', 'bg-violet' => $checked, 'bg-line' => ! $checked])>
        <span @class(['absolute top-[3px] size-[22px] rounded-full bg-white shadow transition-all', 'left-[23px]' => $checked, 'left-[3px]' => ! $checked])></span>
    </span>
    @unless ($srOnlyLabel)
        <span class="admin-label">{{ $label }}</span>
    @endunless
</button>
