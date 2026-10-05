# Designs

## Maquette de référence

**Canevas Claude Design « Maquette portfolio Nganjie v3 »** : https://claude.ai/artifact/WHuo9YWHgvLmiPsxzvn6jp (privé, à partager depuis le menu Partager pour d'autres personnes).

Il contient deux pages :
- **Site public** : Accueil, Liste des projets, Détail d'un projet, Accueil mobile.
- **Administration** : Connexion, Tableau de bord, Projets, Édition d'un projet, Messages.

Le bouton **Play** permet de naviguer entre les écrans (liens, filtres, onglets et interrupteurs fonctionnent).

Cette maquette (v3) remplace la maquette v2 (« Maquette portfolio Nganjie ») pour la version mobile et l'administration (décision D10).

## Mise en œuvre

Les 9 écrans sont réalisés dans l'application (octobre 2026) et ont été comparés à la maquette par captures à 1440 px et 390 px. Les écrans « non dessinés » listés dans [ecrans.md](ecrans.md) ont été construits en suivant les écrans existants.

## Contenu du dossier

| Fichier | Contenu |
|---|---|
| [identite-visuelle.md](identite-visuelle.md) | Couleurs, typographie, espacements, tokens Tailwind |
| [composants.md](composants.md) | Composants récurrents et leur équivalent Blade |
| [ecrans.md](ecrans.md) | Inventaire des écrans, ce que chacun contient et ce qui reste à dessiner |
| [maquette/](maquette/) | Copie des sources du canevas (`*.dc.html`, `canvas.json`) à la date du 2026-10-05 |

Les fichiers de `maquette/` sont une **copie de référence** : ils ne s'ouvrent correctement que dans Claude Design. La source de vérité reste le canevas en ligne ; recopier les fichiers ici après chaque modification importante.

## Règles
- Inspiré du modèle « Devix » (ThemeForest) pour l'ambiance uniquement : ne reprendre ni son code, ni ses images, ni ses textes.
- Les textes entre crochets dans la maquette (`[VOTRE PHOTO]`, `[ANNÉES]`…) sont des contenus à fournir, pas des textes à coder.
