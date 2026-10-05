<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Seed the public profile and attach the CV.
     */
    public function run(): void
    {
        $profile = Profile::current();

        $profile->update([
            'display_name' => 'Nganjie Nzatsi',
            'headline' => ['fr' => 'Développeur full stack C# .NET / Angular'],
            'tagline' => ['fr' => 'Je transforme vos idées en applications'],
            'tagline_highlight' => ['fr' => 'qui tournent'],
            'bio' => ['fr' => "Élève-ingénieur en dernière année de génie logiciel à l'ENSPD et développeur full stack en alternance chez SIGP SC à Douala. Je développe et maintiens des applications en production : API REST, back-offices, interfaces d'administration et intégrations de paiement."],
            'city' => 'Douala, Cameroun',
            'is_available' => true,
            'availability_label' => ['fr' => "Stage de fin d'études de 6 mois dès janvier 2027"],
            'email' => 'nganjienzatsi@gmail.com',
            'phone' => '+237 679 015 958',
            'whatsapp' => '+237679015958',
            'github_url' => 'https://github.com/nganjie',
            'linkedin_url' => 'https://www.linkedin.com/in/nganjie',
            'featured_project_id' => Project::query()->where('slug', 'smartschools')->value('id'),
        ]);

        $cv = __DIR__.'/files/cv-nganjie-nzatsi.pdf';

        if (is_file($cv) && ! $profile->hasCv()) {
            $profile->addMedia($cv)->preservingOriginal()->usingFileName('cv-nganjie-nzatsi.pdf')->toMediaCollection('cv');
            $profile->update(['cv_updated_at' => '2026-10-05']);
        }
    }
}
