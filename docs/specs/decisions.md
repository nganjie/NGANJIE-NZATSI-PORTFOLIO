# Journal des décisions

Chaque décision est numérotée et datée. Une décision remplacée n'est pas effacée : elle passe au statut « Remplacée par Dxx ».

| N° | Date | Décision | Statut |
|---|---|---|---|
| D01 | 2026-10-05 | Stack : **Laravel 13** en application unique (site public + administration). Abandon de la proposition ASP.NET Core + Angular. | Validée |
| D02 | 2026-10-05 | **Pas de Filament.** L'administration est développée sur mesure, dans le même thème que le site public. | Validée par Nganjie |
| D03 | 2026-10-05 | Site public rendu côté serveur avec **Blade + Tailwind CSS 4** (SSR natif, < 1 Ko de JavaScript). | Appliquée |
| D04 | 2026-10-05 | Administration en **Livewire 4** (Alpine.js inclus), composants « classe » dans `app/Livewire/Admin`. | Appliquée |
| D05 | 2026-10-05 | **PostgreSQL 16** en développement et en production ; SQLite en mémoire pour les tests (la suite passe aussi sur PostgreSQL). | Appliquée |
| D06 | 2026-10-05 | **Docker Compose** : `docker-compose.yml` (local) et `docker-compose.prod.yml` (production). | Appliquée |
| D07 | 2026-10-05 | Champs traduisibles en **JSON** (`{"fr": "…", "en": "…"}`) avec `spatie/laravel-translatable`. | Appliquée |
| D08 | 2026-10-05 | Images avec **`spatie/laravel-medialibrary`** : conversions WebP 400 / 800 / 1600 px et 1200×630 pour le partage, générées en file d'attente. | Appliquée |
| D09 | 2026-10-05 | Tests avec **Pest 4** ; style de code avec **Pint** ; intégration continue GitHub Actions. | Appliquée |
| D10 | 2026-10-05 | Maquette de référence : canevas Claude Design « Maquette portfolio Nganjie v3 » (9 écrans). | Validée |
| D11 | 2026-10-05 | **Laravel Boost** installé (consignes et compétences pour les agents). | Appliquée |
| D12 | 2026-10-05 | Éditeur riche : **Trix** (léger, sans dépendance JS lourde). Le HTML est nettoyé côté serveur avec `symfony/html-sanitizer`. Les images se gèrent dans la galerie, pas dans le texte. | Appliquée (répond à Q5) |
| D13 | 2026-10-05 | Serveur web : **Caddy** au lieu de Nginx. HTTPS Let's Encrypt automatique, compression, en-têtes de cache, un seul fichier de configuration pour le local et la production. | Appliquée |
| D14 | 2026-10-05 | **Pas de cache des modèles** pour les pages publiques. Laravel 13 refuse par défaut de désérialiser des objets depuis le cache (sécurité) ; l'accueil ne fait qu'une dizaine de requêtes indexées. Seuls les paramètres (tableaux simples) sont mis en cache. | Appliquée |
| D15 | 2026-10-05 | Ajout du type de projet **Freelance** (en plus de Professionnel, Personnel, Académique). Un filtre sans projet n'est pas affiché. | Appliquée |
| D16 | 2026-10-05 | Les listes (étiquettes, points clés, résultats) sont saisies **une par ligne** dans un champ texte traduisible, plutôt que dans des tableaux JSON. | Appliquée |
| D17 | 2026-10-05 | Mention de disponibilité **affichée** au lancement, avec le texte du CV (« Stage de fin d'études de 6 mois dès janvier 2027 »). Désactivable en un clic dans le profil. | Appliquée (répond à Q4, à confirmer) |
| D18 | 2026-10-06 | Compatibilité **MySQL 8 / MariaDB 10.6+** en plus de PostgreSQL : moteur InnoDB forcé (`DB_ENGINE`), recherche d'admin adaptée à chaque base. Testé sur MySQL 8.4 et MariaDB 11. | Appliquée |
| D19 | 2026-10-06 | **Animations** maison (CSS + `resources/js/motion.js`, sans bibliothèque) : révélations au défilement, titres mot par mot, parallaxe, bande défilante, en-tête collant. Désactivées si « réduire les animations ». Lighthouse inchangé (95–97). | Appliquée |
