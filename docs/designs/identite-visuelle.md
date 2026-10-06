# Identité visuelle

## Couleurs

| Token | Valeur | Usage |
|---|---|---|
| `paper` | `#FAFAF7` | Fond clair principal |
| `mist` | `#EFEEEA` | Fond gris : section contact, pastilles du menu, boutons secondaires |
| `ink` | `#0E0E10` | Texte, sections sombres, barre latérale admin, bouton noir |
| `night-footer` | `#17171A` | Pied de page |
| `violet` | `#6A1BF0` | Accent principal, poste actuel, bouton e-mail — **texte blanc dessus** |
| `lime` | `#A6F20A` | Accent secondaire, boutons principaux, surlignage, pastilles numérotées — **texte noir dessus** |
| `lilac` | `#DCCBFF` | Fond de la photo, étiquettes douces |
| `night` | `#0B1533` | Bloc image de projet |
| `muted` | `#55545A` | Texte secondaire sur fond clair |
| `muted-dark` | `#D5D4DC` / `#B9B8C2` | Texte secondaire sur fond sombre |
| `line` | `#DEDDD8` | Filets sur fond clair |
| `line-dark` | `#2A2A30` | Filets sur fond sombre |

Couleurs d'état (admin) : succès `#E4F9C0` / `#2B5C00`, danger `#A11B1B`, avertissement `#FFB86B` sur fond sombre.

Couleurs d'accent d'un projet (`accent_color`) : `violet`, `lime`, `night`, `lilac`, `black` (`ink`), `grey` (`mist`). Le filet intérieur est blanc à 45 % sur les fonds foncés et noir à 30 % sur les fonds clairs.

## Typographie

| Rôle | Police | Graisse | Taille (ordinateur / mobile) | Détails |
|---|---|---|---|---|
| Grand titre (haut de page) | Schibsted Grotesk | 800 | 104 px / 46 px | Majuscules, interlettrage −0.03em, interligne 0.95 |
| Titre de section | Schibsted Grotesk | 800 | 64 px / 34 px | Majuscules, −0.03em, interligne 1 |
| Titre de carte | Schibsted Grotesk | 700 | 24–34 px | −0.02em, interligne 1.1–1.15 |
| Sur-titre / libellé / bouton | Schibsted Grotesk | 700 | 13–14 px | Majuscules, interlettrage 0.04em |
| Texte courant | Figtree | 400–600 | 17 px / 16 px | Interligne 1.6 |
| Texte d'introduction | Figtree | 400 | 21 px / 17 px | Interligne 1.5 |

## Formes et espacements

- Largeur de contenu : 1180 px max, marges latérales 24 px (16 px sur mobile).
- Grilles : passage à une colonne sous 900 px.
- Rayons : boutons et pastilles `999px` ; cartes `16px` ; formulaire de contact `20px` ; images de projet `6px` avec filet intérieur à `14px` du bord (rayon `3px`).
- Sections : 96 à 112 px de marge verticale sur ordinateur, 48 à 56 px sur mobile.
- Boutons : hauteur minimale 56 px (public), 44–48 px (admin) ; zone cliquable ≥ 44 px partout.
- Survol : soulèvement de 4 px (`translateY(-4px)`), désactivé avec `prefers-reduced-motion`.
- Cartes de méthode et citations : bordure noire 1 px, rotation de −1.5° à 1.5°.
- Formes décoratives du haut de page : disque vert citron (≈ 560 px) et pilule violette inclinée (≈ −28°), en partie hors cadre.

## Tokens Tailwind CSS 4

À placer dans `resources/css/app.css` (étape 02) :

```css
@import 'tailwindcss';

@theme {
  --color-paper: #FAFAF7;
  --color-mist: #EFEEEA;
  --color-ink: #0E0E10;
  --color-night-footer: #17171A;
  --color-violet: #6A1BF0;
  --color-lime: #A6F20A;
  --color-lilac: #DCCBFF;
  --color-night: #0B1533;
  --color-muted: #55545A;
  --color-muted-dark: #B9B8C2;
  --color-line: #DEDDD8;
  --color-line-dark: #2A2A30;

  --font-display: 'Schibsted Grotesk', ui-sans-serif, sans-serif;
  --font-sans: 'Figtree', ui-sans-serif, sans-serif;

  --tracking-display: -0.03em;
  --tracking-label: 0.04em;

  --container-content: 1180px;
  --radius-card: 16px;
  --radius-media: 6px;
}
```

## Animations

Principe : du mouvement qui accompagne la lecture, jamais qui la bloque. Animations courtes (0,8 à 1,1 s), uniquement sur `transform`, `opacity` et `clip-path` (aucun décalage de mise en page), sans bibliothèque externe (`resources/js/motion.js`, ~2 Ko).

| Élément | Effet |
|---|---|
| Grands titres (`data-split`) | Les mots montent un à un derrière un masque ; le mot surligné est peint en vert citron de gauche à droite |
| Formes du haut de page | Le disque « respire » lentement ; disque et pilule suivent légèrement la souris et le défilement (parallaxe) |
| Bande défilante | Deux bandeaux croisés (vert citron et noir) qui défilent en sens inverse ; pause au survol |
| Images de projet (`data-reveal="wipe"`) | Ouverture en rideau de bas en haut ; au survol, l'image zoome et le nom remonte |
| Cartes et listes (`data-reveal-group`) | Apparition en cascade au défilement |
| Cartes « méthode » et citation (`drop`) | Tombent en place en pivotant |
| Poste actuel (`band`) | La bande violette se déploie de gauche à droite |
| Pastilles et étiquettes (`pop`) | Petit rebond à l'apparition |
| En-tête | Collé en haut, fond flouté après défilement, se cache en descendant et revient en remontant |
| Détail d'un projet | Barre de progression de lecture vert citron en haut de l'écran |
| Disponibilité | Point vert qui pulse doucement |

Accessibilité : tout est désactivé si le système demande de réduire les animations. Sans JavaScript (ou si le script ne se charge pas dans les 3 secondes), tout le contenu reste visible. Les titres découpés gardent leur texte complet pour les lecteurs d'écran (`aria-label`).
