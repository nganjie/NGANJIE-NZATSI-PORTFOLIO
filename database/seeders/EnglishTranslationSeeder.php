<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\ProcessStep;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillDomain;
use App\Models\Technology;
use App\Support\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Adds the English version of the initial content.
 *
 * Only empty English fields are filled: French texts and English texts
 * already written in the admin are never overwritten, so this seeder can be
 * run safely on an existing site (php artisan db:seed --class=EnglishTranslationSeeder).
 */
class EnglishTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $this->profile();
        $this->projects();
        $this->experiences();
        $this->skillDomains();
        $this->technologies();
        $this->processSteps();
        $this->settings();
    }

    private function profile(): void
    {
        $this->fill(Profile::current(), [
            'headline' => 'Full stack developer, C# .NET / Angular',
            'tagline' => 'I turn your ideas into applications',
            'tagline_highlight' => 'that run',
            'bio' => 'Final-year software engineering student at ENSPD and full stack developer on a work-study contract at SIGP SC in Douala. I build and maintain applications in production: REST APIs, back offices, admin interfaces and payment integrations.',
            'availability_label' => '6-month final-year internship from January 2027',
        ]);
    }

    private function projects(): void
    {
        /** @var array<string, array<string, mixed>> $english */
        $english = require __DIR__.'/data/projects.en.php';

        foreach ($english as $slug => $fields) {
            $project = Project::query()->where('slug', $slug)->first();

            if ($project === null) {
                continue;
            }

            $tasks = $fields['tasks'] ?? [];
            unset($fields['tasks']);

            $this->fill($project, $fields);

            foreach ($project->tasks()->get() as $index => $task) {
                if (! isset($tasks[$index])) {
                    continue;
                }

                [$title, $body] = $tasks[$index];
                $this->fill($task, ['title' => $title, 'body' => $body]);
            }
        }
    }

    private function experiences(): void
    {
        $english = [
            'SIGP SC Cameroun Sarl' => [
                'title' => 'Full stack developer, C# .NET / Angular (work-study)',
                'highlights' => "Full stack development of a software suite: SmartSchools, ExbilCore, SportBetAfrica, AladjHub, AfricaExchanges, sigpsc.com\n.NET back end (up to .NET 10): REST APIs, services, webhooks, scheduled jobs, unit tests\nAngular front end (versions 17 to 22) for web portals and admin consoles\nAPI analysis, integration and testing; corrective and evolutive maintenance",
            ],
            'PayOol' => [
                'title' => 'Full stack Laravel developer – Fintech',
                'highlights' => "Two money transaction apps: PayOol and PrismCard\nVisa and Mastercard virtual cards, account top-ups\nMulti-API architecture so that several card providers can coexist\nSoleasPay, Eversend and Strowallet API integrations; marketplace",
            ],
            'MikrotekNetwork' => [
                'title' => 'Front-end developer',
                'highlights' => "Front-end redesign of a Wi-Fi ticket sales application\nNode.js real-time notification server over WebSocket",
            ],
            'École Nationale Supérieure Polytechnique de Douala (ENSPD)' => [
                'title' => 'Software engineering degree (work-study programme)',
                'highlights' => 'Final year; 6-month final-year internship from January 2027',
            ],
            'Université de Douala' => [
                'title' => 'Bachelor\'s degree in computer science',
            ],
            'Lycée de Njombé' => [
                'title' => 'Scientific baccalaureate (series C), with honours',
            ],
        ];

        foreach ($english as $organization => $fields) {
            Experience::query()->where('organization', $organization)->get()
                ->each(fn (Experience $experience) => $this->fill($experience, $fields));
        }
    }

    private function skillDomains(): void
    {
        $english = [
            'API et back-end' => ['API & back end', 'Solid REST APIs, tested services and scheduled processing, in .NET as well as Laravel.', "C# / .NET 10\nREST APIs\nWebhooks\nScheduled jobs\nUnit tests\nPHP / Laravel\nNode.js"],
            'Interfaces web' => ['Web interfaces', 'Clear, fast and easy-to-use web portals and admin consoles.', "Angular 17 to 22\nTypeScript\nHTML\nCSS / SCSS\nTailwind CSS\nBootstrap"],
            'Fintech et temps réel' => ['Fintech & real time', 'Reliable money flows and instant exchanges between servers and clients.', "Mobile Money\nVirtual cards\nSoleasPay\nEversend\nStrowallet\nWebSocket"],
            'Données et livraison' => ['Data & delivery', 'Well-modelled databases, versioned code and production-ready applications.', "PostgreSQL\nMySQL\nGit / GitHub\nAzure\nDocker"],
        ];

        foreach (SkillDomain::all() as $domain) {
            if ($fields = $english[$domain->getTranslation('title', 'fr', false)] ?? null) {
                $this->fill($domain, ['title' => $fields[0], 'description' => $fields[1], 'tags' => $fields[2]]);
            }
        }
    }

    private function technologies(): void
    {
        $categories = [
            'Back-end' => 'Back end',
            'Front-end' => 'Front end',
            'Base de données' => 'Database',
            'Temps réel' => 'Real time',
            'Déploiement' => 'Deployment',
            'Cloud' => 'Cloud',
            'Paiement' => 'Payments',
            'Mobile' => 'Mobile',
            'Outils' => 'Tools',
        ];

        foreach (Technology::all() as $technology) {
            if ($category = $categories[$technology->getTranslation('category', 'fr', false)] ?? null) {
                $this->fill($technology, ['category' => $category]);
            }
        }
    }

    private function processSteps(): void
    {
        $english = [
            'Comprendre' => ['Understand', 'I listen to the needs, the users and the constraints before writing a single line of code.'],
            'Concevoir' => ['Design', 'I model the data, the APIs and the screens, then validate the plan with you.'],
            'Développer' => ['Build', 'I deliver in short, tested iterations that you can try as we go.'],
            'Livrer' => ['Deliver', 'I deploy, document and train the users.'],
        ];

        foreach (ProcessStep::all() as $step) {
            if ($fields = $english[$step->getTranslation('title', 'fr', false)] ?? null) {
                $this->fill($step, ['title' => $fields[0], 'body' => $fields[1]]);
            }
        }
    }

    private function settings(): void
    {
        $english = [
            'seo.default_title' => 'Nganjie Nzatsi — Full stack C# .NET / Angular developer in Douala',
            'seo.default_description' => 'Full stack developer in Douala: .NET REST APIs, Angular interfaces, Laravel and payment integrations. Looking for a final-year internship from January 2027.',
        ];

        foreach ($english as $key => $text) {
            $value = Settings::get($key);
            $value = is_array($value) ? $value : array_filter(['fr' => $value]);

            if (blank($value['en'] ?? null)) {
                $value['en'] = $text;
                Settings::set($key, $value);
            }
        }
    }

    /**
     * Set the English translation of each field that has none yet.
     *
     * @param  array<string, string|null>  $fields
     */
    private function fill(Model $model, array $fields): void
    {
        foreach ($fields as $attribute => $text) {
            if ($text !== null && blank($model->getTranslation($attribute, 'en', false))) {
                $model->setTranslation($attribute, 'en', $text);
            }
        }

        if ($model->isDirty()) {
            $model->save();
        }
    }
}
