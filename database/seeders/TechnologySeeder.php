<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Technologies, the first eight being shown on the home page.
     *
     * @var list<array{0: string, 1: string, 2: bool}>
     */
    private const TECHNOLOGIES = [
        ['C# .NET', 'Back-end', true],
        ['Angular', 'Front-end', true],
        ['TypeScript', 'Front-end', true],
        ['Laravel', 'Back-end', true],
        ['PostgreSQL', 'Base de données', true],
        ['WebSocket', 'Temps réel', true],
        ['Docker', 'Déploiement', true],
        ['Azure', 'Cloud', true],
        ['API REST', 'Back-end', false],
        ['PHP', 'Back-end', false],
        ['Node.js', 'Back-end', false],
        ['MySQL', 'Base de données', false],
        ['Mobile Money', 'Paiement', false],
        ['Tailwind CSS', 'Front-end', false],
        ['HTML & CSS', 'Front-end', false],
        ['JavaScript', 'Front-end', false],
        ['PWA', 'Front-end', false],
        ['.NET MAUI', 'Mobile', false],
        ['Git', 'Outils', false],
    ];

    public function run(): void
    {
        foreach (self::TECHNOLOGIES as $index => [$name, $category, $onHome]) {
            Technology::query()->updateOrCreate(['name' => $name], [
                'category' => ['fr' => $category],
                'show_on_home' => $onHome,
                'position' => $index + 1,
            ]);
        }
    }
}
