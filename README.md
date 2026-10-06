# Portfolio de Nganjie Nzatsi

Portfolio personnel administrable de Nganjie Nzatsi, développeur full stack C# .NET / Angular à Douala.

- **Site public** : accueil, liste des projets filtrable, études de cas, formulaire de contact, téléchargement du CV.
- **Administration** (`/admin`) : tout le contenu se modifie sans toucher au code (profil, CV, projets, compétences, technologies, parcours, méthode, messages, médias, paramètres).

La documentation complète (spécifications, plans d'étapes, identité visuelle) est dans [`docs/`](docs/README.md).

## Stack

| Couche | Choix |
|---|---|
| Framework | Laravel 13 (PHP 8.3+) |
| Site public | Blade + Tailwind CSS 4, rendu serveur |
| Administration | Livewire 4 (Alpine.js inclus), éditeur Trix |
| Base de données | PostgreSQL 16 |
| Traductions | `spatie/laravel-translatable` (FR aujourd'hui, EN prêt pour la V2) |
| Images | `spatie/laravel-medialibrary` : WebP en 400 / 800 / 1600 px |
| Tests | Pest 4 (SQLite et PostgreSQL) |
| Serveur web | Caddy (HTTPS automatique en production) |

## Démarrage local avec Docker (recommandé)

Prérequis : Docker et Docker Compose.

```bash
cp .env.example .env
# Dans .env : renseigner ADMIN_PASSWORD (DB_HOST et MAIL_HOST sont fournis par docker-compose.yml)
docker compose up -d
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

| Service | Adresse |
|---|---|
| Site | http://localhost:8000 |
| Administration | http://localhost:8000/admin |
| E-mails reçus (Mailpit) | http://localhost:8025 |
| Vite (rechargement à chaud) | http://localhost:5173 |

Services lancés par `docker-compose.yml` : `app` (PHP-FPM), `web` (Caddy), `queue` (worker de file d'attente : conversions d'images, e-mails), `vite`, `db` (PostgreSQL), `mailpit`.

## Démarrage local sans Docker

Prérequis : PHP 8.3+ (extensions `pdo_pgsql`, `gd`, `intl`, `zip`, `exif`), Composer, Node 22, PostgreSQL.

```bash
cp .env.example .env            # renseigner DB_* et ADMIN_PASSWORD
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
composer run dev                # serveur + worker de file d'attente + Vite
```

### Avec MySQL ou MariaDB (WAMP, XAMPP, Laragon…)

PostgreSQL est la base recommandée, mais le projet fonctionne aussi avec MySQL 8 et MariaDB 10.6+ (testé sur MySQL 8.4 et MariaDB 11). Les tables sont toujours créées en InnoDB, même si le serveur utilise MyISAM par défaut.

```env
DB_CONNECTION=mysql        # ou mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nganjie_nzatsi_portfolio
DB_USERNAME=root
DB_PASSWORD=
```

Après une migration interrompue, repartir de zéro avec `php artisan migrate:fresh --seed`.

## Version anglaise

Le site est bilingue : français à la racine (`/`, `/projets`), anglais sous `/en` (`/en`, `/en/projects`), avec un sélecteur FR / EN dans l'en-tête et le pied de page. Les textes anglais se saisissent dans l'onglet **English** de chaque formulaire de l'administration.

Pour ajouter le contenu anglais de départ sur un site déjà rempli, sans toucher au français ni aux traductions déjà saisies :

```bash
php artisan db:seed --class=EnglishTranslationSeeder
```

## Compte administrateur

- Le seed crée le compte `ADMIN_EMAIL` avec le mot de passe `ADMIN_PASSWORD` du fichier `.env`. Si `ADMIN_PASSWORD` est vide, un mot de passe aléatoire est affiché une seule fois dans la console.
- Pour créer le compte ou changer son mot de passe à tout moment : `php artisan admin:create`.
- Le mot de passe se change aussi depuis **Administration › Paramètres**.

## Mise en production

Le fichier `docker-compose.prod.yml` lance : `app` (PHP-FPM, migrations automatiques au démarrage), `queue`, `scheduler`, `web` (Caddy avec certificat HTTPS Let's Encrypt automatique) et `db` (PostgreSQL, non exposé).

Sur un serveur (VPS) avec Docker, et un nom de domaine qui pointe vers son adresse IP :

```bash
git clone <ce dépôt> portfolio && cd portfolio
cp .env.production.example .env
# Compléter .env : APP_KEY, APP_URL, SITE_ADDRESS (le domaine), DB_PASSWORD, MAIL_*, ADMIN_PASSWORD
docker compose -f docker-compose.prod.yml run --rm app php artisan key:generate --show   # copier la clé dans APP_KEY
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan db:seed --force          # premier lancement uniquement
```

Mise à jour :

```bash
git pull
docker compose -f docker-compose.prod.yml up -d --build
```

Sauvegarde de la base (le dossier `backups/` est monté dans le conteneur `db`) :

```bash
docker compose -f docker-compose.prod.yml exec db sh -c 'pg_dump -U "$POSTGRES_USER" "$POSTGRES_DB" > /backups/portfolio-$(date +%F).sql'
```

Les médias envoyés sont dans le volume Docker `media` : à inclure dans les sauvegardes.

## Commandes utiles

| Commande | Rôle |
|---|---|
| `php artisan test` | Lancer les tests |
| `vendor/bin/pint` | Formater le code PHP |
| `npm run build` | Construire les fichiers front |
| `php artisan admin:create` | Créer l'administrateur ou changer son mot de passe |
| `php artisan messages:purge` | Effacer les messages supprimés depuis plus de 30 jours (planifié chaque nuit) |
| `php artisan db:seed` | Recharger le contenu initial (ne crée pas de doublons) |

## Organisation du code

```
app/
  Enums/                 types et statuts (projet, expérience, message, couleur)
  Http/Controllers/Site  pages publiques, contact, CV, sitemap
  Http/Controllers/Admin connexion et mot de passe oublié
  Livewire/Admin/        écrans d'administration
  Models/                modèles Eloquent (champs traduisibles, médias)
  Support/               paramètres, nettoyage HTML, envoi de médias, statistiques
database/seeders/        contenu initial (data/projects.php : les projets)
resources/views/
  site/                  pages publiques
  components/site/       composants publics (image, bloc projet, titres…)
  components/admin/      composants d'administration
  livewire/admin/        vues des écrans d'administration
docker/                  Dockerfile, configuration PHP et Caddy
docs/                    spécifications, plans, designs
```
