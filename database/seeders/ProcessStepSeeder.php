<?php

namespace Database\Seeders;

use App\Models\ProcessStep;
use Illuminate\Database\Seeder;

class ProcessStepSeeder extends Seeder
{
    /**
     * Seed the four steps of the working method.
     */
    public function run(): void
    {
        $steps = [
            ['Comprendre', "J'écoute le besoin, les utilisateurs et les contraintes avant d'écrire une ligne de code."],
            ['Concevoir', 'Je modélise les données, les API et les écrans, puis je valide le plan avec vous.'],
            ['Développer', 'Je livre par étapes courtes et testées, que vous pouvez essayer au fur et à mesure.'],
            ['Livrer', 'Je mets en ligne, je documente et je forme les utilisateurs.'],
        ];

        foreach ($steps as $index => [$title, $body]) {
            ProcessStep::query()->updateOrCreate(['position' => $index + 1], [
                'title' => ['fr' => $title],
                'body' => ['fr' => $body],
            ]);
        }
    }
}
