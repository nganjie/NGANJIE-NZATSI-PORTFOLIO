# Architecture

## Stack

| Couche | Choix | Décision |
|---|---|---|
| Langage / framework | PHP 8.3+, Laravel 13 | D01 |
| Vues publiques | Blade + composants Blade, Tailwind CSS 4 via Vite | D03 |
| Administration | Blade + Livewire + Alpine.js | D02, D04 |
| Base de données | PostgreSQL 16+ | D05 |
| Traductions | `spatie/laravel-translatable` | D07 |
| Médias | `spatie/laravel-medialibrary` | D08 |
| E-mails | Mailables Laravel, file d'attente `database` ; Mailpit en local | — |
| Tests | Pest 4, SQLite en mémoire | D09 |
| Style de code | Laravel Pint | D09 |
| Environnement | Docker Compose | D06 |
| Outillage IA | Laravel Boost | D11 |

## Organisation du code

```
app/
  Enums/                 ProjectType, ProjectStatus, ExperienceType, MessageType
  Http/
    Controllers/
      Site/              HomeController, ProjectController, ContactController, CvController
      Admin/             AuthController (connexion, mot de passe oublié)
    Middleware/          (si besoin)
    Requests/            ContactRequest, …
  Livewire/Admin/        Dashboard, Profile, Projects/Index, Projects/Edit, Skills, Technologies,
                         Experiences, ProcessSteps, Messages, Media, Settings
  Mail/                  NewContactMessage
  Models/                User, Profile, Project, ProjectTask, Technology, SkillDomain,
                         Experience, ProcessStep, Message, Setting, PageView
  Support/               Settings (lecture en cache des paramètres)
resources/
  css/app.css            tokens du thème (@theme Tailwind)
  views/
    components/site/     bouton, pastille, carte-projet, bloc-image, titre-section, …
    components/admin/    layout, carte, champ, interrupteur, onglets-langue, …
    site/                home, projects/index, projects/show
    admin/               auth/login, …
    livewire/admin/      vues des composants Livewire
routes/
  web.php                routes publiques
  admin.php              routes d'administration (préfixe /admin, middleware auth)
```

## Routes

| Méthode | URL | Nom | Accès |
|---|---|---|---|
| GET | `/` | `home` | Public |
| GET | `/projets` | `projects.index` | Public |
| GET | `/projets/{slug}` | `projects.show` | Public |
| POST | `/contact` | `contact.store` | Public, limité en débit |
| GET | `/cv` | `cv.download` | Public (compte les téléchargements) |
| GET | `/sitemap.xml` | `sitemap` | Public |
| GET | `/admin/connexion` | `admin.login` | Invités |
| POST | `/admin/connexion` | — | Invités, limité en débit |
| GET/POST | `/admin/mot-de-passe-oublie`, `/admin/reinitialiser/{token}` | — | Invités |
| GET | `/admin` | `admin.dashboard` | Authentifié |
| GET | `/admin/profil`, `/admin/projets`, `/admin/projets/creer`, `/admin/projets/{project}`, `/admin/competences`, `/admin/technologies`, `/admin/parcours`, `/admin/methode`, `/admin/messages`, `/admin/medias`, `/admin/parametres` | `admin.*` | Authentifié |

Les URL publiques sont en français ; un préfixe de langue (`/en/...`) sera ajouté en V2 (voir [bilingue.md](bilingue.md)).

## Conventions

- Code en anglais, contenus et interface en français.
- Contrôleurs fins : la logique va dans les modèles, les Form Requests ou de petites classes d'action.
- Enums PHP pour tous les types et statuts.
- Chaque fonctionnalité livrée avec ses tests Pest (voir la section « Tests » de chaque plan).
- `vendor/bin/pint` et `php artisan test` passent avant chaque commit.
- Une branche et des commits courts par étape ; message de commit en français.
