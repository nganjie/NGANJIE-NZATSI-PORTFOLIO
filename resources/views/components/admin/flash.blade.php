<div x-data="{ show: false, message: '' }"
    x-on:notify.window="message = $event.detail.message ?? $event.detail[0]?.message ?? ''; show = true; clearTimeout(window.__notifyTimer); window.__notifyTimer = setTimeout(() => show = false, 3500)"
    x-init="@if (session('status')) message = @js(session('status')); show = true; setTimeout(() => show = false, 3500) @endif"
    class="pointer-events-none fixed right-4 bottom-4 z-50 sm:right-8 sm:bottom-8">
    <div x-show="show" x-cloak x-transition role="status" aria-live="polite"
        class="pointer-events-auto flex items-center gap-3 rounded-2xl bg-ink px-5 py-4 text-[15px] font-semibold text-white shadow-2xl">
        <span aria-hidden="true" class="grid size-6 place-items-center rounded-full bg-lime text-xs text-ink">✓</span>
        <span x-text="message"></span>
    </div>
</div>
