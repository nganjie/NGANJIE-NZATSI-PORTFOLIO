# 01 — Mise en place

**Statut** : À faire · **Prérequis** : — · **Bloquée par** : —

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
- [ ] `composer require laravel/boost --dev` puis `php artisan boost:install` ; relire les consignes générées
- [ ] Écrire `docker-compose.yml` et les Dockerfile nécessaires
- [ ] Configurer PostgreSQL dans `.env.example` et `config/database.php`
- [ ] Configurer la file d'attente `database` et Mailpit
- [ ] Installer les paquets Spatie et publier leurs configurations / migrations
- [ ] Installer Livewire (après réponse à Q1)
- [ ] Configurer Pest pour SQLite en mémoire (`phpunit.xml`)
- [ ] Locale de l'application : `fr`, fuseau `Africa/Douala`
- [ ] Ajouter `lang/fr` (`php artisan lang:publish` + traductions françaises de validation)
- [ ] Script `composer setup` / `composer dev` à jour
- [ ] Réécrire `README.md`

## Critères d'acceptation
- `docker compose up -d` puis `php artisan migrate` fonctionnent sur une machine neuve en suivant le README.
- `php artisan test` et `vendor/bin/pint --test` passent.
- Les e-mails envoyés en local apparaissent dans Mailpit.
- Les messages de validation s'affichent en français.

## Tests
- Test de fumée : `GET /` répond 200.
