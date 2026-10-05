# Journal des décisions

Chaque décision est numérotée et datée. Une décision remplacée n'est pas effacée : elle passe au statut « Remplacée par Dxx ».

| N° | Date | Décision | Statut |
|---|---|---|---|
| D01 | 2026-10-05 | Stack : **Laravel 13** en application unique (site public + administration). Abandon de la proposition ASP.NET Core + Angular. | Validée (le dépôt est initialisé en Laravel) |
| D02 | 2026-10-05 | **Pas de Filament.** L'administration est développée sur mesure, dans le même thème que le site public. | Validée par Nganjie |
| D03 | 2026-10-05 | Site public rendu côté serveur avec **Blade + Tailwind CSS 4** (SSR natif, peu de JavaScript). | Proposée |
| D04 | 2026-10-05 | Administration en **Blade + Livewire + Alpine.js** pour les interactions (tri par glisser-déposer, interrupteurs, onglets FR/EN, formulaires sans rechargement). | Proposée, à confirmer |
| D05 | 2026-10-05 | Base de données **PostgreSQL** en développement et en production ; SQLite en mémoire pour les tests. | Proposée |
| D06 | 2026-10-05 | Environnement local et déploiement avec **Docker Compose** (app PHP-FPM, Nginx, PostgreSQL, Mailpit en local). | Proposée |
| D07 | 2026-10-05 | Champs traduisibles stockés en **JSON** (`{"fr": "...", "en": "..."}`) avec `spatie/laravel-translatable`. | Proposée |
| D08 | 2026-10-05 | Images gérées avec **`spatie/laravel-medialibrary`** : compression, déclinaisons en plusieurs tailles, `srcset`. | Proposée |
| D09 | 2026-10-05 | Tests avec **Pest 4** (déjà installé) ; style de code avec **Pint**. | Validée |
| D10 | 2026-10-05 | Maquette de référence : canevas Claude Design « Maquette portfolio Nganjie v3 » (9 écrans). Remplace la maquette v2 pour la mobile et l'admin. | Validée |
| D11 | 2026-10-05 | Installer **Laravel Boost** avant tout développement applicatif (exigence du `CLAUDE.md`). | Validée |

## Détail des décisions proposées

### D04 — Livewire pour l'administration
- **Pourquoi** : interactions riches (tri, interrupteurs, recherche instantanée) sans construire une SPA ni une API séparée ; reste dans l'écosystème Laravel.
- **Alternative** : Blade + Alpine.js seul, avec des formulaires classiques. Plus simple, mais chaque action recharge la page.
- **À confirmer avec Nganjie** avant l'étape 06.

### D07 — Traductions en JSON
- **Pourquoi** : une seule colonne par champ, pas de jointure, migration V2 nulle.
- **Alternative** : colonnes `_fr` / `_en`. Simple mais double chaque champ et rend l'ajout d'une langue coûteux.
