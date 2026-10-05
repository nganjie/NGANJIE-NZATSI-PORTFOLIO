# 03 — Modèle de données et seed

**Statut** : À faire · **Prérequis** : 01 · **Bloquée par** : —

## Objectif
Créer toutes les tables, modèles, relations et enums de la V1, et un seed qui rend le site présentable dès le premier lancement.

## Références
- Specs : [modele-de-donnees.md](../specs/modele-de-donnees.md), [donnees-initiales.md](../specs/donnees-initiales.md), [bilingue.md](../specs/bilingue.md)

## Livrables
- Migrations : `profiles`, `projects`, `project_tasks`, `technologies`, `project_technology`, `skill_domains`, `experiences`, `process_steps`, `messages`, `settings`, `page_views`, `media` (medialibrary), colonne `last_login_at` sur `users`.
- Enums : `ProjectType`, `ProjectStatus`, `ExperienceType`, `MessageType`, `AccentColor`.
- Modèles avec `HasTranslations`, `InteractsWithMedia`, casts, relations, scopes (`published()`, `featured()`, `ordered()`).
- Factories pour chaque modèle.
- Seeders : `AdminSeeder`, `ProfileSeeder`, `ProjectSeeder`, `SkillSeeder`, `TechnologySeeder`, `ExperienceSeeder`, `ProcessStepSeeder`, `SettingSeeder`.
- Classe `Settings` avec lecture en cache.
- Commande `php artisan admin:create`.

## Tâches
- [ ] Écrire les migrations et les index
- [ ] Écrire les enums (avec méthode `label()` en français)
- [ ] Écrire les modèles et relations
- [ ] Scopes `published`, `featured`, `ordered`
- [ ] Génération du slug unique depuis le titre français
- [ ] Factories
- [ ] Seeders avec les données réelles (ignorer les champs à fournir)
- [ ] Classe `Settings` + invalidation du cache à l'écriture
- [ ] Commande `admin:create`

## Critères d'acceptation
- `php artisan migrate:fresh --seed` se termine sans erreur sur PostgreSQL.
- Les 6 projets, 4 domaines, 8+ technologies, 3 lignes de parcours et 4 étapes existent après le seed.
- Aucun mot de passe en dur dans le code.

## Tests
- Relations et scopes de chaque modèle.
- Unicité et génération du slug.
- Les champs traduisibles renvoient le français par défaut et retombent sur le français si l'anglais est vide.
