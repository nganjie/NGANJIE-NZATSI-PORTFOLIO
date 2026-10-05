# 09 — Admin : projets

**Statut** : Terminé · **Prérequis** : 07, 10 · **Bloquée par** : Q5 (éditeur riche)

## Objectif
Gérer les projets de bout en bout : liste, création, modification, publication, ordre, mise à la une.

## Références
- Specs : [administration.md](../specs/administration.md#projets), [modele-de-donnees.md](../specs/modele-de-donnees.md#projects), [securite.md](../specs/securite.md) (nettoyage du HTML)
- Designs : [ecrans.md](../designs/ecrans.md) — « Projets », « Édition d'un projet »

## Livrables
- Composants `Admin\Projects\Index` et `Admin\Projects\Edit`.
- Intégration de l'éditeur riche (Tiptap ou Trix selon Q5) et nettoyage du HTML.

## Tâches
- [x] Liste : recherche, filtres type et statut, vignette couleur, badge de statut
- [x] Interrupteur « À la une » instantané
- [x] Tri par glisser-déposer + boutons clavier ; enregistrement de `position`
- [x] Formulaire : informations, slug (généré + modifiable + unique)
- [x] Onglets FR / EN sur les champs traduisibles
- [x] Éditeur riche pour l'étude de cas + nettoyage
- [x] Tâches « Ce que j'ai fait » : ajout, modification, suppression, ordre
- [x] Image de couverture et galerie (avec l'étape 10)
- [x] Couleur d'accent, technologies (ajout / retrait)
- [x] Référencement avec compteurs de caractères et aperçu
- [x] Statut, `published_at`, aperçu public
- [x] Suppression avec confirmation (médias supprimés aussi)

## Critères d'acceptation
- Un projet créé dans l'admin apparaît sur le site une fois publié, à la bonne position.
- Le HTML malveillant (`<script>`, `onerror=`) est retiré à l'enregistrement.
- Le tri est conservé après rechargement.

## Tests
- Création, modification, validation (slug unique, champs obligatoires FR).
- Publication remplit `published_at` une seule fois.
- Réordonnancement.
- Nettoyage du HTML.
- Accès refusé aux invités sur chaque action Livewire.

## Notes de réalisation (2026-10-05)

- Éditeur Trix (D12), HTML nettoyé par `App\Support\RichText`.
- Tri des projets, des tâches et de la galerie avec `wire:sort` + boutons clavier.
- Changer le slug redirige vers la nouvelle adresse d'édition.
