<x-mail::message>
# Nouveau message depuis le portfolio

**Type de demande :** {{ $contactMessage->type->label() }}
**Nom :** {{ $contactMessage->name }}
**E-mail :** {{ $contactMessage->email }}
**Reçu le :** {{ $contactMessage->created_at->locale('fr')->translatedFormat('j F Y à H:i') }}

<x-mail::panel>
{!! nl2br(str_replace(['[', ']', '(', ')', '*', '_', '`', '#', '!'], ['&#91;', '&#93;', '&#40;', '&#41;', '&#42;', '&#95;', '&#96;', '&#35;', '&#33;'], e($contactMessage->body))) !!}
</x-mail::panel>

Répondez directement à cet e-mail pour écrire à {{ $contactMessage->name }}.

<x-mail::button :url="route('admin.messages', ['message' => $contactMessage->id])">
Ouvrir dans l'administration
</x-mail::button>
</x-mail::message>
