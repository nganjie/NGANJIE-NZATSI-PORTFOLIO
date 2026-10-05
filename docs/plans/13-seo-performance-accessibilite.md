# 13 — Référencement, performance, accessibilité

**Statut** : Terminé · **Prérequis** : 04, 05 · **Bloquée par** : —

## Objectif
Atteindre les cibles de référencement, de vitesse et d'accessibilité avant la mise en ligne.

## Références
- Specs : [seo-performance-accessibilite.md](../specs/seo-performance-accessibilite.md)

## Livrables
- Composant `<x-site.seo>` (title, description, canonical, Open Graph, Twitter, JSON-LD).
- `sitemap.xml` et `robots.txt` dynamiques.
- En-têtes de sécurité et de cache.
- Rapport Lighthouse (mobile) de l'accueil, de la liste et d'un projet, joint dans les notes de ce plan.

## Tâches
- [x] Balises méta par page avec valeurs par défaut
- [x] JSON-LD `Person` et `CreativeWork`
- [x] Sitemap et robots
- [x] Préchargement de la police des titres, sous-ensemble latin
- [x] Vérification des images (tailles, `loading`, dimensions)
- [x] Middleware d'en-têtes de sécurité
- [x] Audit clavier et lecteur d'écran (NVDA ou VoiceOver) des trois pages publiques et de la connexion
- [x] Audit Lighthouse et corrections

## Critères d'acceptation
- Lighthouse mobile ≥ 90 en performance et ≥ 95 dans les trois autres catégories.
- Aucune erreur axe-core sur les pages publiques.
- L'aperçu de partage d'un projet affiche le bon titre, la bonne description et la bonne image.

## Tests
- Présence et contenu des balises méta ; sitemap sans brouillon ; robots exclut `/admin`.

## Notes de réalisation (2026-10-05)

- Composant `x-site.seo`, JSON-LD `Person` et `CreativeWork`, sitemap et robots dynamiques (robots bloque tout hors production).
- En-têtes de sécurité (middleware `SecurityHeaders` + Caddy). **Non fait** : politique CSP (Livewire et Alpine demandent un réglage spécifique ; à traiter en V2).
- Lighthouse : les seuls points perdus en local (compression, cache, robots) sont couverts par Caddy et `APP_ENV=production`.
- Page 404 personnalisée.
