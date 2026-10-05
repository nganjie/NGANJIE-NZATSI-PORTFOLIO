# 12 — Admin : messages et paramètres

**Statut** : Terminé · **Prérequis** : 06, 07 · **Bloquée par** : —

## Objectif
Lire et traiter les messages reçus, et régler les paramètres généraux du site.

## Références
- Specs : [administration.md](../specs/administration.md#messages), [contact-et-messages.md](../specs/contact-et-messages.md)
- Designs : [ecrans.md](../designs/ecrans.md) — « Messages »

## Livrables
- Composant `Admin\Messages` (liste + détail).
- Composant `Admin\Settings`.
- Tâche planifiée de purge des messages supprimés depuis plus de 30 jours.

## Tâches
- [x] Onglets boîte de réception / archivés, compteur de non lus
- [x] Ouverture = lu ; « Marquer non lu »
- [x] Archiver / désarchiver, supprimer (suppression douce)
- [x] « Répondre par e-mail » (`mailto:` avec objet pré-rempli)
- [x] Paramètres : SEO par défaut, image de partage, sections visibles, e-mail de notification
- [x] Commande planifiée `messages:purge`

## Critères d'acceptation
- Le badge de la barre latérale et le tableau de bord suivent l'état lu / non lu.
- Masquer une section dans les paramètres la retire de l'accueil et du menu.

## Tests
- Lecture, non-lu, archivage, suppression, purge ; enregistrement des paramètres et vidage du cache.

## Notes de réalisation (2026-10-05)

- Purge planifiée chaque nuit à 3 h (`messages:purge`).
- Paramètres : image de partage et changement du mot de passe ajoutés.
