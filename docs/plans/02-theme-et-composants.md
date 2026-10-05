# 02 — Thème et composants de base

**Statut** : À faire · **Prérequis** : 01 · **Bloquée par** : —

## Objectif
Traduire l'identité visuelle en tokens Tailwind et en composants Blade réutilisables, pour que les pages se construisent ensuite par assemblage.

## Références
- Designs : [identite-visuelle.md](../designs/identite-visuelle.md), [composants.md](../designs/composants.md)
- Specs : [seo-performance-accessibilite.md](../specs/seo-performance-accessibilite.md) (polices, accessibilité)

## Livrables
- `resources/css/app.css` avec le bloc `@theme` (couleurs, polices, rayons, largeur de contenu).
- Polices Schibsted Grotesk et Figtree auto-hébergées (WOFF2).
- Composants Blade publics et admin listés dans [composants.md](../designs/composants.md).
- Mises en page `layouts/site.blade.php` et `layouts/admin.blade.php`.
- Une page de démonstration des composants, accessible uniquement en local (`/_composants`).

## Tâches
- [ ] Déclarer les tokens dans `@theme`
- [ ] Télécharger et déclarer les polices (`@font-face`, préchargement)
- [ ] Layout public : en-tête (menu en pastilles + menu mobile), pied de page, lien d'évitement
- [ ] Layout admin : barre latérale, zone de contenu, messages flash
- [ ] Composants publics : bouton, pastille de menu, étiquette, titre de section (sur-titre + grand titre + surlignage), bloc image de projet, carte de compétence, carte de méthode, ligne de parcours
- [ ] Composants admin : carte, champ (label + aide + erreur), interrupteur, onglets de langue, pastilles de couleur, poignée de tri, badge de statut, bouton de confirmation
- [ ] Styles `:focus-visible` et `prefers-reduced-motion`
- [ ] Page de démonstration des composants

## Critères d'acceptation
- La page de démonstration reproduit fidèlement les éléments de la maquette (couleurs, typographie, rayons, survols).
- Navigation au clavier possible sur tous les composants interactifs, focus visible.
- Aucun texte de contenu en dur dans les composants (tout passe par des props ou des slots).

## Tests
- Rendu de chaque composant avec ses props principales (tests de vue Pest).
