# 14 — Déploiement

**Statut** : En cours (bloquée par Q2, Q3) · **Prérequis** : toutes les étapes V1 · **Bloquée par** : Q2 (domaine), Q3 (hébergement)

## Objectif
Mettre le site en ligne de façon sûre, reproductible et sauvegardée.

## Références
- Specs : [securite.md](../specs/securite.md), [architecture.md](../specs/architecture.md)

## Livrables
- `docker-compose.prod.yml` (images optimisées, pas de Mailpit, worker de file d'attente, planificateur).
- Configuration Nginx avec HTTPS (Let's Encrypt ou Cloudflare).
- Intégration continue GitHub Actions : Pint, tests, build Vite.
- Procédure de déploiement et de retour arrière dans `docs/plans/14-deploiement.md` (section Notes).
- Sauvegarde quotidienne de la base et des médias.

## Tâches
- [ ] Acheter / configurer le domaine (Q2)
- [ ] Préparer le serveur (Q3) : Docker, pare-feu, utilisateur dédié
- [x] Image de production (OPcache, `optimize`, assets construits)
- [ ] HTTPS et redirection, HSTS
- [ ] Service SMTP de production pour les notifications
- [x] Worker et planificateur (`schedule:work` ou cron)
- [x] Pipeline CI
- [ ] Sauvegardes + test de restauration
- [ ] Création du compte administrateur en production
- [ ] Vérification finale : formulaire de contact, CV, aperçu de partage

## Critères d'acceptation
- Le site répond en HTTPS sur le domaine choisi.
- Un message envoyé depuis le site arrive dans la boîte de Nganjie.
- Une restauration de sauvegarde a été testée.
- La CI bloque une fusion si les tests échouent.

## Tests
- Pipeline CI vert sur la branche principale.

## Notes de réalisation (2026-10-05)

- Prêt : `docker-compose.prod.yml`, `.env.production.example`, procédure dans le README, intégration continue `.github/workflows/tests.yml` (Pint + tests SQLite et PostgreSQL).
- Reste : choisir le domaine (Q2) et l'hébergement (Q3), configurer le SMTP de production, mettre en place la sauvegarde automatique.
