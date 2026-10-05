@props(['status'])

<span @class([
    'inline-block rounded-full px-3 py-1 text-[13px] font-semibold whitespace-nowrap',
    'bg-lime-soft text-success' => $status === \App\Enums\ProjectStatus::Published,
    'bg-mist text-muted' => $status !== \App\Enums\ProjectStatus::Published,
])>{{ $status->label() }}</span>
