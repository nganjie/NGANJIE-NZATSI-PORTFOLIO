# 07 — Admin : authentification et mise en page

**Statut** : Terminé · **Prérequis** : 02, 03 · **Bloquée par** : Q1 (Livewire)

## Objectif
Sécuriser l'accès à l'administration et poser la mise en page commune à tous ses écrans.

## Références
- Specs : [administration.md](../specs/administration.md#connexion), [securite.md](../specs/securite.md)
- Designs : [ecrans.md](../designs/ecrans.md) — « Connexion », barre latérale des écrans admin

## Livrables
- `routes/admin.php` (préfixe `/admin`, noms `admin.*`, middleware `auth`).
- `Admin\AuthController` : connexion, déconnexion, mot de passe oublié, réinitialisation.
- Vues `admin/auth/*`.
- Layout admin finalisé (badge des messages non lus).

## Tâches
- [x] Routes et redirection des invités vers `/admin/connexion`
- [x] Écran de connexion conforme à la maquette
- [x] Limitation des tentatives (5 / 15 min par e-mail + IP)
- [x] « Rester connecté »
- [x] Mot de passe oublié et réinitialisation (e-mails en français)
- [x] Mise à jour de `last_login_at`
- [x] Déconnexion (POST) avec invalidation de session
- [x] Barre latérale avec élément actif et compteur de messages non lus

## Critères d'acceptation
- Aucune page `/admin/*` n'est accessible sans connexion.
- Le blocage après 5 échecs fonctionne et s'affiche clairement.
- Le parcours mot de passe oublié fonctionne de bout en bout avec Mailpit.

## Tests
- Invité redirigé ; connexion valide ; mauvais mot de passe ; blocage au 6ᵉ essai ; déconnexion ; réinitialisation.

## Notes de réalisation (2026-10-05)

- Routes dans `routes/admin.php`, chargées avec le préfixe `/admin`.
- E-mail de réinitialisation en français.
- Le mot de passe se change aussi dans Paramètres.
