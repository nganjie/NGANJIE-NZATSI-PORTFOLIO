# Médias

## Images

- Formats acceptés : JPEG, PNG, WebP. Taille maximale à l'envoi : 8 Mo.
- À l'envoi : orientation corrigée, métadonnées EXIF retirées.
- Déclinaisons générées en file d'attente (medialibrary « conversions ») :

| Nom | Largeur | Usage |
|---|---|---|
| `thumb` | 400 px | Admin, vignettes |
| `md` | 800 px | Cartes de projet |
| `lg` | 1600 px | Couverture, galerie |
| `og` | 1200 × 630 recadré (JPEG) | Aperçu de partage (couverture de projet, image de partage du profil) |

- `thumb`, `md` et `lg` sont en **WebP** (qualité 80) ; l'original est conservé. Les conversions sont faites par le worker de file d'attente : sans worker, l'original est affiché.
- Affichage : `<img>` avec `srcset`, `sizes`, `width` / `height` (pas de décalage de mise en page), `loading="lazy"` sauf pour l'image du haut de page.
- Texte alternatif obligatoire (traduisible) ; légende facultative.
- Tant qu'un projet n'a pas d'image, on affiche le bloc de couleur d'accent avec le filet intérieur (comme dans la maquette), sans texte.

## Photo de profil

Recadrée en carré, déclinaisons `sm` (300 px) et `md` (600 px) en WebP. Sans photo, les initiales s'affichent.

## CV

- PDF uniquement, 5 Mo maximum, collection `cv` du profil (un seul fichier, le nouveau remplace l'ancien).
- Servi par la route `/cv` (voir [site-public.md](site-public.md)).

## Stockage

- Disque `public` en V1 (lien symbolique `storage:link`), dans un volume Docker persistant.
- Passage possible à un stockage objet compatible S3 plus tard, sans changement de code.
