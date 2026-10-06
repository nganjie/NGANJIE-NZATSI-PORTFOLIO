# Bilingue FR/EN

**État : en place depuis le 2026-10-06** (anticipé sur la V2).

## Adresses

| Page | Français | Anglais |
|---|---|---|
| Accueil | `/` | `/en` |
| Liste des projets | `/projets` | `/en/projects` |
| Détail d'un projet | `/projets/{slug}` | `/en/projects/{slug}` |

- Le slug d'un projet est commun aux deux langues.
- Les routes anglaises portent le préfixe de nom `en.` (`en.home`, `en.projects.show`). Dans les vues, toujours utiliser `localized_route('projects.show', $project)` : le lien reste dans la langue de la page.
- Le middleware `SetLocale` (alias `locale`) applique la langue du groupe de routes. L'administration reste en français.
- Le formulaire de contact, le CV, le sitemap et robots.txt ont une seule adresse ; le formulaire envoie la langue de la page (champ `locale`) pour revenir sur la bonne version avec des messages dans la bonne langue.

## Sélecteur de langue

Composant `x-site.lang-switch` (en-tête et pied de page). Il mène à **la même page** dans l'autre langue (`Localization::switchUrl()`), filtres compris.

## Textes d'interface

- Tous les libellés passent par `__('Texte français')`. Le français est la langue source : la clé **est** le texte français.
- Les traductions anglaises sont dans `lang/en.json` ; les messages de validation dans `lang/en/validation.php`.
- Pour ajouter un libellé : l'écrire en français dans la vue avec `__()`, puis ajouter sa traduction dans `lang/en.json`.

## Contenus

- Tous les champs de contenu sont traduisibles (JSON `{"fr": …, "en": …}`), modifiables dans l'admin avec l'onglet **English**.
- Un champ anglais vide affiche le texte français (repli configuré dans `AppServiceProvider`).
- Les paramètres SEO par défaut (titre, description) sont aussi bilingues.
- Textes alternatifs et légendes des images : clés `alt.fr` / `alt.en`, `caption.fr` / `caption.en` (repli sur le français).

## Contenu anglais initial

`EnglishTranslationSeeder` ajoute la version anglaise du contenu de départ (profil, 14 projets et leurs réalisations, parcours, compétences, catégories des technologies, méthode, SEO). Il **ne remplit que les champs anglais vides** et ne touche jamais au français : on peut le lancer sur un site existant.

```bash
php artisan db:seed --class=EnglishTranslationSeeder
```

## Référencement

- `<html lang>`, `og:locale` et `og:locale:alternate` suivent la langue.
- Chaque page publie ses équivalents : `<link rel="alternate" hreflang="fr|en|x-default">`.
- Le sitemap liste les deux versions de chaque page avec leurs `xhtml:link` alternatifs.
