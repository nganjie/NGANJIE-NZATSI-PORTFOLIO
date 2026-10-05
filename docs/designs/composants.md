# Composants

Correspondance entre les éléments récurrents de la maquette et les composants Blade à créer à l'étape 02.

## Site public (`resources/views/components/site/`)

| Composant | Élément de la maquette | Props principales |
|---|---|---|
| `button` | Bouton pilule vert citron, noir ou violet | `variant` (lime, ink, violet, mist), `href`, `size` |
| `nav-pill` | Lien du menu en pastille grise, vert au survol | `href`, `active` |
| `section-heading` | Sur-titre numéroté + grand titre en majuscules, mot surligné | `eyebrow`, `title`, `highlight`, `dark` |
| `highlight` | Mot surligné vert citron à coins arrondis | slot |
| `project-media` | Bloc de couleur avec filet intérieur, ou image | `accent`, `media`, `height` |
| `project-row` | Projet à la une : fiche + grande image | `project` |
| `project-card` | Carte de la liste des projets | `project` |
| `skill-card` | Carte de domaine de compétence (fond noir) | `domain`, `number` |
| `experience-row` | Ligne de parcours ; variante « actuel » sur fond violet | `experience` |
| `process-card` | Carte de méthode inclinée avec pastille numérotée | `step`, `rotation` |
| `tag` | Étiquette arrondie | `variant` |
| `fact` | Fiche Rôle / Contexte / Stack / Période | `label`, slot |
| `image` | Image responsive (`srcset`, `sizes`, `loading`) | `media`, `conversion`, `sizes`, `eager` |
| `seo` | Balises méta | `title`, `description`, `image`, `type` |
| `decor` | Formes décoratives du haut de page | — |

## Administration (`resources/views/components/admin/`)

| Composant | Élément de la maquette | Props principales |
|---|---|---|
| `layout` | Barre latérale noire + contenu | `title` |
| `nav-item` | Lien de la barre latérale, vert citron si actif | `href`, `active`, `badge` |
| `page-header` | Fil d'Ariane, titre en majuscules, actions | `title`, `breadcrumb` |
| `card` | Carte blanche bordée | `title` |
| `stat` | Indicateur du tableau de bord | `label`, `value` |
| `field` | Libellé + champ + aide + erreur | `label`, `name`, `help` |
| `toggle` | Interrupteur (`role="switch"`) | `wire:model`, `label` |
| `lang-tabs` | Onglets Français / English | `current` |
| `color-swatches` | Choix de la couleur d'accent | `wire:model`, `options` |
| `status-badge` | Badge Publié / Brouillon | `status` |
| `sort-handle` | Poignée de glisser-déposer + boutons clavier | — |
| `confirm-button` | Bouton de suppression avec confirmation | `message` |
| `empty-state` | Liste vide avec appel à l'action | `title`, `action` |
