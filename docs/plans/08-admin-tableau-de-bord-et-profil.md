# 08 — Admin : tableau de bord, profil et CV

**Statut** : À faire · **Prérequis** : 07 · **Bloquée par** : —

## Objectif
Donner une vue d'ensemble à la connexion et permettre de modifier le profil et le CV.

## Références
- Specs : [administration.md](../specs/administration.md#tableau-de-bord-v1), [medias.md](../specs/medias.md#photo-de-profil)
- Designs : [ecrans.md](../designs/ecrans.md) — « Tableau de bord »

## Livrables
- Composant `Admin\Dashboard`.
- Composant `Admin\Profile` (formulaire avec onglets de langue).

## Tâches
- [ ] Indicateurs : non lus, publiés, brouillons, date du CV
- [ ] Derniers messages
- [ ] Bloc « État du site » avec lien vers le profil
- [ ] Encadré V2 pour les statistiques
- [ ] Formulaire profil : tous les champs de `profiles`, onglets FR/EN
- [ ] Envoi et recadrage de la photo
- [ ] Envoi du CV (PDF) et mise à jour de `cv_updated_at`
- [ ] Choix du projet phare

## Critères d'acceptation
- Les indicateurs reflètent la base.
- Modifier le profil change l'accueil immédiatement (cache vidé).
- Un nouveau CV remplace l'ancien et la date se met à jour.

## Tests
- Calcul des indicateurs ; validation du profil ; envoi d'un CV non PDF refusé ; vidage du cache de l'accueil.
