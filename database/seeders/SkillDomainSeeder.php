<?php

namespace Database\Seeders;

use App\Models\SkillDomain;
use Illuminate\Database\Seeder;

class SkillDomainSeeder extends Seeder
{
    /**
     * Seed the four skill domains shown on the home page.
     */
    public function run(): void
    {
        $domains = [
            ['API et back-end', 'Des API REST solides, des services et des traitements planifiés testés, en .NET comme en Laravel.', "C# / .NET 10\nAPI REST\nWebhooks\nJobs planifiés\nTests unitaires\nPHP / Laravel\nNode.js"],
            ['Interfaces web', "Des portails et des consoles d'administration clairs, rapides et faciles à prendre en main.", "Angular 17 à 22\nTypeScript\nHTML\nCSS / SCSS\nTailwind CSS\nBootstrap"],
            ['Fintech et temps réel', "Des flux d'argent fiables et des échanges instantanés entre serveurs et clients.", "Mobile Money\nCartes virtuelles\nSoleasPay\nEversend\nStrowallet\nWebSocket"],
            ['Données et livraison', 'Des bases bien modélisées, du code versionné et des applications prêtes pour la production.', "PostgreSQL\nMySQL\nGit / GitHub\nAzure\nDocker"],
        ];

        foreach ($domains as $index => [$title, $description, $tags]) {
            SkillDomain::query()->updateOrCreate(['position' => $index + 1], [
                'title' => ['fr' => $title],
                'description' => ['fr' => $description],
                'tags' => ['fr' => $tags],
            ]);
        }
    }
}
