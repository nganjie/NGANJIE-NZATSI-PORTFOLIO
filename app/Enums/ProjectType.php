<?php

namespace App\Enums;

enum ProjectType: string
{
    case Professional = 'professional';
    case Freelance = 'freelance';
    case Personal = 'personal';
    case Academic = 'academic';

    public function label(): string
    {
        return match ($this) {
            self::Professional => __('Professionnel'),
            self::Freelance => __('Freelance'),
            self::Personal => __('Personnel'),
            self::Academic => __('Académique'),
        };
    }

    /**
     * Slug used in the public filter URL (?type=…).
     */
    public function slug(): string
    {
        return match ($this) {
            self::Professional => 'professionnel',
            self::Freelance => 'freelance',
            self::Personal => 'personnel',
            self::Academic => 'academique',
        };
    }

    public static function fromSlug(?string $slug): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->slug() === $slug) {
                return $case;
            }
        }

        return null;
    }
}
