<?php

namespace App\Enums;

enum MessageType: string
{
    case Job = 'job';
    case Freelance = 'freelance';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Job => __("Offre d'emploi ou de stage"),
            self::Freelance => __('Mission freelance'),
            self::Other => __('Autre demande'),
        };
    }
}
