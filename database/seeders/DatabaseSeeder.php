<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with the real portfolio content.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            TechnologySeeder::class,
            ProjectSeeder::class,
            ProfileSeeder::class,
            ExperienceSeeder::class,
            SkillDomainSeeder::class,
            ProcessStepSeeder::class,
            SettingSeeder::class,
            EnglishTranslationSeeder::class,
        ]);
    }
}
