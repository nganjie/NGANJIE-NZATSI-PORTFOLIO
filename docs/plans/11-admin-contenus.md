# 11 — Admin : compétences, technologies, parcours, méthode

**Statut** : Terminé · **Prérequis** : 07 · **Bloquée par** : —

## Objectif
Permettre de gérer les quatre listes de contenu de l'accueil avec un écran commun.

## Références
- Specs : [administration.md](../specs/administration.md#compétences-technologies-parcours-méthode)
- Designs : mise en page admin de [ecrans.md](../designs/ecrans.md) (pas d'écran dédié : reprendre la liste « Projets » + panneau latéral)

## Livrables
- Trait ou composant de base « liste ordonnable + panneau d'édition ».
- Composants `Admin\Skills`, `Admin\Technologies`, `Admin\Experiences`, `Admin\ProcessSteps`.

## Tâches
- [x] Composant de base réutilisable (liste, tri, panneau, confirmation de suppression)
- [x] Compétences : saisie des étiquettes une par une
- [x] Technologies : « afficher sur l'accueil », avertissement au-delà de 8
- [x] Parcours : dates ou libellé libre, « en cours », un seul poste actuel
- [x] Méthode : titre et texte
- [x] Onglets FR / EN partout

## Critères d'acceptation
- Chaque modification se voit sur l'accueil.
- Cocher « poste actuel » sur une ligne le retire des autres.

## Tests
- CRUD et ordre pour chacun des quatre écrans ; règle du poste actuel unique.

## Notes de réalisation (2026-10-05)

- Classe de base `App\Livewire\Admin\Concerns\OrderedCrud` partagée par les quatre écrans.
