# 05 — Pages projets publiques

**Statut** : Terminé · **Prérequis** : 04 · **Bloquée par** : Q6 (droits sur les projets SIGP SC)

## Objectif
Construire la liste filtrable des projets et la page de détail (étude de cas).

## Références
- Specs : [site-public.md](../specs/site-public.md#liste-des-projets-projets)
- Designs : [ecrans.md](../designs/ecrans.md) — « Liste des projets », « Détail d'un projet »

## Livrables
- Routes `/projets` et `/projets/{slug}` + `Site\ProjectController`.
- Vues `site/projects/index.blade.php` et `site/projects/show.blade.php`.
- Enregistrement des vues de projet dans `page_views`.

## Tâches
- [x] Liste : filtres par paramètre d'URL avec compteurs, filtres vides masqués
- [x] Carte de projet (composant réutilisé)
- [x] Détail : fil d'Ariane, étiquettes, en-tête, couverture, fiches, étude de cas, tâches, galerie, enseignement, résultats, projet suivant
- [x] Masquage des blocs vides
- [x] 404 pour un projet brouillon ; aperçu avec bandeau pour l'administrateur connecté
- [x] Enregistrement des vues (hors admin et robots)

## Critères d'acceptation
- Conforme à la maquette à 1440 px et 390 px.
- Les filtres fonctionnent sans JavaScript.
- « Projet suivant » boucle sur le premier projet.

## Tests
- Liste : seuls les projets publiés, filtre par type, compteurs.
- Détail : 200 pour un projet publié, 404 pour un brouillon (invité), 200 avec bandeau (admin).
- Une vue est enregistrée pour un invité, pas pour l'admin.

## Notes de réalisation (2026-10-05)

- Les filtres utilisent `?type=professionnel|freelance|personnel|academique`.
- L'aperçu des brouillons affiche un bandeau et un lien « Modifier ».
