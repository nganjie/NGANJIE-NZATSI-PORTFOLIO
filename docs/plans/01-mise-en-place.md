# 01 — Mise en place

**Statut** : Terminé · **Prérequis** : — · **Bloquée par** : —

## Objectif
Avoir un environnement de développement reproductible (Docker), une base PostgreSQL, les paquets choisis installés et des outils de qualité qui tournent.

## Références
- Specs : [architecture.md](../specs/architecture.md), [decisions.md](../specs/decisions.md) (D01, D05, D06, D07, D08, D09, D11)

## Livrables
- `docker-compose.yml` : services `app` (PHP-FPM 8.3+), `web` (Nginx), `db` (PostgreSQL 16), `mailpit`, `queue` (worker).
- `.env.example` complété (PostgreSQL, Mailpit, `ADMIN_PASSWORD`, file d'attente `database`).
- Laravel Boost installé.
- Paquets : `spatie/laravel-translatable`, `spatie/laravel-medialibrary`, `livewire/livewire` (si Q1 = oui).
- README du dépôt réécrit en français : prérequis, installation, commandes courantes.

## Tâches
- [x] `composer require laravel/boost --dev` puis `php artisan boost:install` ; relire les consignes générées
- [x] Écrire `docker-compose.yml` et les Dockerfile nécessaires
- [x] Configurer PostgreSQL dans `.env.example` et `config/database.php`
- [x] Configurer la file d'attente `database` et Mailpit
- [x] Installer les paquets Spatie et publier leurs configurations / migrations
- [x] Installer Livewire (après réponse à Q1)
- [x] Configurer Pest pour SQLite en mémoire (`phpunit.xml`)
- [x] Locale de l'application : `fr`, fuseau `Africa/Douala`
- [x] Ajouter `lang/fr` (`php artisan lang:publish` + traductions françaises de validation)
- [x] Script `composer setup` / `composer dev` à jour
- [x] Réécrire `README.md`

## Critères d'acceptation
- `docker compose up -d` puis `php artisan migrate` fonctionnent sur une machine neuve en suivant le README.
- `php artisan test` et `vendor/bin/pint --test` passent.
- Les e-mails envoyés en local apparaissent dans Mailpit.
- Les messages de validation s'affichent en français.

## Tests
- Test de fumée : `GET /` répond 200.

## Notes de réalisation (2026-10-05)

- Laravel Boost 2 installé (consignes + compétences dans `.claude/skills`).
- Paquets : Livewire 4, spatie/laravel-translatable 6, spatie/laravel-medialibrary 11, symfony/html-sanitizer.
- Polices auto-hébergées via `@fontsource` (sous-ensemble latin).
- Docker : un seul `docker/php/Dockerfile` multi-étapes (`dev`, `prod`, `web`) ; Caddy remplace Nginx (D13).
- Traductions françaises dans `lang/fr` (validation, authentification, e-mails).
- Vérifié : l'image de production et la pile `docker-compose.prod.yml` (app, queue, scheduler, Caddy, PostgreSQL) ont été construites et lancées. Envoi d'image → conversion WebP par le worker → service par Caddy : OK. L'étape `base` Alpine n'a pas pu être construite dans l'environnement de développement (dépôts Alpine bloqués) ; elle suit le modèle officiel de l'image PHP.
