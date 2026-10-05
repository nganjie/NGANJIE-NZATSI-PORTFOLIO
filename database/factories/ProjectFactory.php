<?php

namespace Database\Factories;

use App\Enums\AccentColor;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(2, true));

        return [
            'title' => ['fr' => $title],
            'slug' => Str::slug($title),
            'summary' => ['fr' => fake()->sentence(12)],
            'type' => ProjectType::Personal,
            'context' => ['fr' => 'Projet personnel'],
            'role' => ['fr' => 'Développeur full stack'],
            'period' => ['fr' => '2025'],
            'case_study' => ['fr' => '<p>'.fake()->paragraph().'</p>'],
            'accent_color' => AccentColor::Violet,
            'status' => ProjectStatus::Published,
            'is_featured' => false,
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => ProjectStatus::Draft, 'published_at' => null]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }

    public function professional(): static
    {
        return $this->state(['type' => ProjectType::Professional]);
    }
}
