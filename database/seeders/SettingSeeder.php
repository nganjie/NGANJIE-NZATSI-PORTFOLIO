<?php

namespace Database\Seeders;

use App\Support\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed the default site settings.
     */
    public function run(): void
    {
        Settings::set('seo.default_title', 'Nganjie Nzatsi — Développeur full stack C# .NET / Angular à Douala');
        Settings::set('seo.default_description', "Développeur full stack à Douala : API REST .NET, interfaces Angular, Laravel et intégrations de paiement. Recherche un stage de fin d'études dès janvier 2027.");
        Settings::set('sections.visible', array_keys(Settings::SECTIONS));
        Settings::set('contact.notify_email', 'nganjienzatsi@gmail.com');
    }
}
