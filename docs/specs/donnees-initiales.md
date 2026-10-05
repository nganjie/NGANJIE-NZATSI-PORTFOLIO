# Données initiales (seed)

Le seed (`php artisan db:seed`) rend le site présentable dès le premier lancement. Il peut être relancé sans créer de doublons. Sources : le CV et la [recherche sur les projets](recherche-projets.md).

## Administrateur
`AdminSeeder` : e-mail `ADMIN_EMAIL` (par défaut nganjienzatsi@gmail.com), mot de passe `ADMIN_PASSWORD` du `.env`. Si `ADMIN_PASSWORD` est vide, un mot de passe aléatoire est généré et affiché une seule fois.

## Profil (`ProfileSeeder`)
- Nom : Nganjie Nzatsi. Titre : Développeur full stack C# .NET / Angular. Ville : Douala, Cameroun.
- Titre d'accueil : « Je transforme vos idées en applications » + « qui tournent » (surligné).
- Présentation : reprise du profil du CV.
- Disponibilité : affichée, « Stage de fin d'études de 6 mois dès janvier 2027 ».
- E-mail, téléphone (+237 679 015 958), WhatsApp (même numéro, Q7), GitHub, LinkedIn (Q10).
- CV : `database/seeders/files/cv-nganjie-nzatsi.pdf`. Projet phare : SmartSchools.

## Projets (`database/seeders/data/projects.php`)

| # | Projet | Type | Statut | À la une | Couleur |
|---|---|---|---|---|---|
| 1 | SmartSchools | Professionnel | Publié | Oui | violet |
| 2 | ExbilCore | Professionnel | Publié | Oui | bleu nuit |
| 3 | SportBetAfrica | Professionnel | Publié | Oui | vert citron |
| 4 | PayOol | Professionnel | Publié | Oui | noir |
| 5 | PrismCard | Professionnel | Publié | Non | lilas |
| 6 | AladjHub | Professionnel | Publié | Non | gris |
| 7 | Site institutionnel SIGP SC | Professionnel | Publié | Non | violet |
| 8 | MikroTek Network | Professionnel | Publié | Non | vert citron |
| 9 | Plateforme SaaS pour gérants de hotspot Wi-Fi | Personnel | Publié | Non | bleu nuit |
| 10 | Plugin revendeurs hotspot | Personnel | Publié | Non | lilas |
| 11 | AfricaExchanges | Professionnel | Brouillon | Non | bleu nuit |
| 12 | SSMP | Professionnel | Brouillon | Non | violet |
| 13 | Ancestri | Personnel | Brouillon | Non | noir |
| 14 | Signalement des patients isolés | Personnel | Brouillon | Non | gris |

Chaque projet a son résumé, son contexte, son rôle, sa période, ses étiquettes, ses technologies et, quand l'information existe, une étude de cas et des réalisations numérotées. L'enseignement retenu et les résultats sont laissés vides (C5).

## Parcours (`ExperienceSeeder`)
1. SIGP SC Cameroun Sarl : développeur full stack C# .NET / Angular (alternance), févr. 2024 → aujourd'hui, **poste actuel**.
2. PayOol : développeur full stack Laravel – Fintech, janv. → mai 2024.
3. MikrotekNetwork : développeur front-end, févr. → juin 2023.
4. ENSPD : cycle d'ingénieur en génie logiciel par alternance, 2024 – 2027.
5. Université de Douala : licence d'informatique, 2021 – 2024.
6. Lycée de Njombé : baccalauréat C, mention Bien, 2021.

## Compétences (`SkillDomainSeeder`)
1. API et back-end : C# / .NET 10, API REST, webhooks, jobs planifiés, tests unitaires, PHP / Laravel, Node.js.
2. Interfaces web : Angular 17 à 22, TypeScript, HTML, CSS / SCSS, Tailwind CSS, Bootstrap.
3. Fintech et temps réel : Mobile Money, cartes virtuelles, SoleasPay, Eversend, Strowallet, WebSocket.
4. Données et livraison : PostgreSQL, MySQL, Git / GitHub, Azure, Docker.

## Technologies (`TechnologySeeder`)
Sur l'accueil (8) : C# .NET, Angular, TypeScript, Laravel, PostgreSQL, WebSocket, Docker, Azure. Autres : API REST, PHP, Node.js, MySQL, Mobile Money, Tailwind CSS, HTML & CSS, JavaScript, PWA, .NET MAUI, Git.

## Méthode (`ProcessStepSeeder`)
Comprendre, Concevoir, Développer, Livrer.

## Paramètres (`SettingSeeder`)
Titre et description SEO par défaut, toutes les sections visibles, notifications de contact vers nganjienzatsi@gmail.com.
