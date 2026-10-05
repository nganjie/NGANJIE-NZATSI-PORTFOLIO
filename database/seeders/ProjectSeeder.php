<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Seed the projects described in database/seeders/data/projects.php.
     */
    public function run(): void
    {
        /** @var list<array<string, mixed>> $projects */
        $projects = require __DIR__.'/data/projects.php';

        foreach ($projects as $index => $data) {
            $translated = fn (?string $value) => $value === null ? null : ['fr' => $value];

            $project = Project::query()->updateOrCreate(['slug' => $data['slug']], [
                'title' => ['fr' => $data['title']],
                'summary' => ['fr' => $data['summary']],
                'type' => $data['type'],
                'status' => $data['status'],
                'is_featured' => $data['is_featured'],
                'accent_color' => $data['accent_color'],
                'context' => $translated($data['context']),
                'role' => $translated($data['role']),
                'period' => $translated($data['period']),
                'demo_url' => $data['demo_url'],
                'tags' => $translated($data['tags']),
                'case_study' => $translated($data['case_study']),
                'lesson' => $translated($data['lesson']),
                'results' => $translated($data['results']),
                'position' => $index + 1,
            ]);

            $technologyIds = collect($data['technologies'])
                ->mapWithKeys(fn (string $name, int $position) => [
                    Technology::query()->where('name', $name)->value('id') => ['position' => $position + 1],
                ])
                ->filter(fn ($pivot, $id) => $id !== null && $id !== '');

            $project->technologies()->sync($technologyIds->all());

            $project->tasks()->delete();

            foreach ($data['tasks'] as $position => [$title, $body]) {
                $project->tasks()->create([
                    'position' => $position + 1,
                    'title' => ['fr' => $title],
                    'body' => ['fr' => $body],
                ]);
            }
        }
    }
}
