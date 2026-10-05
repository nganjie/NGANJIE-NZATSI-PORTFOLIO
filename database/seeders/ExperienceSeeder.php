<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Seed the career and education timeline from the CV.
     */
    public function run(): void
    {
        $experiences = [
            [
                'type' => 'job',
                'organization' => 'SIGP SC Cameroun Sarl',
                'location' => 'Douala',
                'title' => 'Développeur full stack C# .NET / Angular (alternance)',
                'started_at' => '2024-02-01',
                'ended_at' => null,
                'is_current' => true,
                'highlights' => "Développement full stack d'une suite de logiciels : SmartSchools, ExbilCore, SportBetAfrica, AladjHub, AfricaExchanges, sigpsc.com\nBack-end .NET (jusqu'à .NET 10) : API REST, services, webhooks, jobs planifiés, tests unitaires\nFront-end Angular (versions 17 à 22) pour portails web et consoles d'administration\nAnalyse, intégration et tests d'API ; maintenance évolutive et corrective",
            ],
            [
                'type' => 'job',
                'organization' => 'PayOol',
                'location' => 'Douala',
                'title' => 'Développeur full stack Laravel – Fintech',
                'started_at' => '2024-01-01',
                'ended_at' => '2024-05-31',
                'is_current' => false,
                'highlights' => "Deux applications de transactions d'argent : PayOol et PrismCard\nCartes virtuelles Visa et Mastercard, recharges de compte\nArchitecture multi-API pour faire coexister plusieurs fournisseurs de cartes\nIntégration des API SoleasPay, Eversend et Strowallet ; marketplace",
            ],
            [
                'type' => 'job',
                'organization' => 'MikrotekNetwork',
                'location' => 'Douala',
                'title' => 'Développeur front-end',
                'started_at' => '2023-02-01',
                'ended_at' => '2023-06-30',
                'is_current' => false,
                'highlights' => "Refonte du front-end d'une application de vente de tickets Wi-Fi\nServeur Node.js de notifications en temps réel via WebSocket",
            ],
            [
                'type' => 'education',
                'organization' => 'École Nationale Supérieure Polytechnique de Douala (ENSPD)',
                'location' => 'Douala',
                'title' => "Cycle d'ingénieur en génie logiciel, par alternance",
                'started_at' => '2024-09-01',
                'ended_at' => '2027-07-31',
                'date_label' => '2024 – 2027',
                'is_current' => false,
                'highlights' => 'Dernière année ; stage de fin d\'études de 6 mois à partir de janvier 2027',
            ],
            [
                'type' => 'education',
                'organization' => 'Université de Douala',
                'location' => 'Douala',
                'title' => "Licence d'informatique",
                'started_at' => '2021-09-01',
                'ended_at' => '2024-07-31',
                'date_label' => '2021 – 2024',
                'is_current' => false,
                'highlights' => null,
            ],
            [
                'type' => 'education',
                'organization' => 'Lycée de Njombé',
                'location' => 'Njombé',
                'title' => 'Baccalauréat scientifique, série C – mention Bien',
                'started_at' => null,
                'ended_at' => '2021-07-31',
                'date_label' => '2021',
                'is_current' => false,
                'highlights' => null,
            ],
        ];

        foreach ($experiences as $index => $data) {
            Experience::query()->updateOrCreate(
                ['organization' => $data['organization'], 'type' => $data['type']],
                [
                    ...$data,
                    'title' => ['fr' => $data['title']],
                    'date_label' => isset($data['date_label']) ? ['fr' => $data['date_label']] : null,
                    'highlights' => $data['highlights'] ? ['fr' => $data['highlights']] : null,
                    'position' => $index + 1,
                ],
            );
        }
    }
}
