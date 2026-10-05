@props(['label', 'for', 'error' => null, 'help' => null])

@php($errorKey = $error ?? $for)

<div {{ $attributes->class('flex flex-col gap-2') }}>
    <label for="{{ $for }}" class="admin-label">{{ $label }}</label>
    {{ $slot }}
    @if ($help)
        <p class="admin-help" id="{{ $for }}-help">{{ $help }}</p>
    @endif
    @error($errorKey)
        <p class="text-sm text-danger" id="{{ $for }}-error">{{ $message }}</p>
    @enderror
</div>
