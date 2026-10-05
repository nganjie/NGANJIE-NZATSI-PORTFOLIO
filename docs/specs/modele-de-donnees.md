# Modèle de données

Les champs marqués **T** sont traduisibles : colonne `json`, format `{"fr": "…", "en": "…"}` (voir [bilingue.md](bilingue.md)). Toutes les tables ont `id` et `created_at` / `updated_at` sauf mention contraire.

## users
| Colonne | Type | Notes |
|---|---|---|
| name | string | |
| email | string, unique | |
| password | string | haché (bcrypt/argon2) |
| remember_token | string, null | « Rester connecté » |
| last_login_at | timestamp, null | |

Un seul enregistrement, créé par le seed ou une commande `php artisan admin:create`.

## profiles (ligne unique)
| Colonne | Type | Notes |
|---|---|---|
| display_name | string | « Nganjie Nzatsi » |
| headline | json **T** | « Développeur full stack » |
| tagline | json **T** | Grand titre de l'accueil |
| tagline_highlight | json **T** | Partie surlignée du titre (« qui tournent ») |
| bio | json **T** | Présentation courte |
| city | string | « Douala » |
| is_available | boolean | Affiche la mention de disponibilité |
| availability_label | json **T** | « Disponible pour un stage ou un emploi » |
| email | string | |
| whatsapp | string, null | Numéro international |
| phone | string, null | Affiché dans la section contact |
| github_url, linkedin_url | string, null | |
| cv_updated_at | date, null | |
| featured_project_id | FK projects, null | Projet phare du haut de page |
| (médias) | | `photo`, `cv`, `share_image` (image de partage par défaut) via medialibrary |

## projects
| Colonne | Type | Notes |
|---|---|---|
| title | json **T** | |
| slug | string, unique | Généré depuis le titre FR, modifiable |
| summary | json **T** | Résumé (cartes, SEO par défaut) |
| type | enum `professional` / `freelance` / `personal` / `academic` | |
| context | json **T** | « SIGP SC Cameroun, en équipe » |
| role | json **T** | |
| period | json **T** | Texte libre : « Depuis août 2024 » |
| demo_url, repository_url | string, null | |
| case_study | json **T** | HTML issu de l'éditeur riche, nettoyé |
| lesson | json **T**, null | Enseignement retenu |
| results | json **T**, null | Une ligne par résultat |
| tags | json **T**, null | Étiquettes (Fintech, Éducation…), une par ligne |
| accent_color | string | Une des couleurs du thème (`violet`, `lime`, `night`, `lilac`, `black`, `grey`) |
| status | enum `draft` / `published` | |
| is_featured | boolean | Affiché sur l'accueil |
| position | unsigned int | Ordre d'affichage |
| seo_title, seo_description | json **T**, null | Valeurs par défaut : titre et résumé |
| published_at | timestamp, null | |
| (médias) | | `cover` (1), `gallery` (n, avec légende **T** en propriété personnalisée) |

Index : `(status, position)`, `(is_featured, position)`.

## project_tasks
`project_id` FK (cascade), `position`, `title` **T**, `body` **T**. Section « Ce que j'ai fait » ; le numéro affiché est dérivé de `position`.

## technologies
`name` string, `category` **T** (« Backend »), `position`, `show_on_home` boolean (grille de 8 sur l'accueil).

## project_technology (pivot)
`project_id`, `technology_id`, `position`. Clé primaire composite.

## skill_domains
`title` **T**, `description` **T**, `tags` **T** (une étiquette par ligne), `position`.

## experiences
| Colonne | Type | Notes |
|---|---|---|
| type | enum `job` / `education` | |
| organization | string | |
| location | string, null | Ville |
| title | json **T** | Intitulé du poste ou de la formation |
| started_at | date, null | |
| ended_at | date, null | null = en cours |
| date_label | json **T**, null | Libellé libre si les dates exactes sont inconnues |
| highlights | json **T** | Points clés, un par ligne |
| is_current | boolean | Ligne violette mise en avant |
| position | unsigned int | |

## process_steps
`position`, `title` **T**, `body` **T**. Quatre étapes en V1.

## messages
| Colonne | Type | Notes |
|---|---|---|
| type | enum `job` / `freelance` / `other` | Type de demande |
| name | string | |
| email | string | |
| body | text | |
| read_at | timestamp, null | |
| archived_at | timestamp, null | |
| ip_hash | string, null | IP hachée (anti-abus, pas de donnée personnelle en clair) |

Suppression : douce (`deleted_at`), purge définitive après 30 jours.

## settings
`key` string unique, `value` json. Exemples : `seo.default_title`, `seo.default_description`, `sections.visible` (liste des sections de l'accueil), `contact.notify_email`.

## page_views (prévu V2, table créée en V1)
`path`, `project_id` null, `referrer` null, `viewed_at`. Pas d'`updated_at`. Sert aux statistiques du tableau de bord ; le compteur de téléchargements du CV utilise `path = /cv`.

## media (medialibrary)
Table standard du paquet. Propriétés personnalisées : `alt` **T**, `caption` **T**.

## Relations

- `Project` 1—n `ProjectTask`, n—n `Technology`, 1—n médias.
- `Profile` n—1 `Project` (projet phare).
- `PageView` n—1 `Project` (facultatif).
