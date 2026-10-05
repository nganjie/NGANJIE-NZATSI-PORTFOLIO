# Contexte du projet

## Objectif

Créer le portfolio personnel de **Nganjie Nzatsi**, développeur full stack à Douala (Cameroun), composé de :

- un **site public** qui présente son profil, ses projets, ses compétences et son parcours, et permet de le contacter ;
- un **espace d'administration** qui lui permet de tout mettre à jour lui-même, sans toucher au code.

## Public visé

- Recruteurs et entreprises camerounaises, **banques en priorité**.
- Porteurs de projet qui cherchent un développeur.

Conséquences : le site doit inspirer confiance (sobriété, clarté, rigueur), être rapide sur des connexions lentes et lisible sur mobile.

## Principes

- Le contenu du site est **entièrement piloté par l'administration** : aucun texte de contenu en dur dans les vues publiques (les libellés d'interface comme « Envoyer » ne sont pas du contenu).
- **Un seul administrateur** : le propriétaire du site.
- Interface et contenus en **français** ; l'anglais arrive en V2, mais le modèle de données le prévoit dès la V1 (voir [bilingue.md](bilingue.md)).

## Périmètre par version

| Version | Contenu |
|---|---|
| **V1** | Site public complet (accueil, liste des projets, détail d'un projet), contact, CV. Admin : connexion, tableau de bord simple, profil et CV, projets, compétences, technologies, parcours, méthode, messages, médias, paramètres de base. |
| **V2** | Bilingue FR/EN, statistiques de visites, référencement avancé, thème clair/sombre. |
| **V3** | Blog, témoignages, double authentification, sauvegarde et export. |

Hors périmètre V1 : blog, témoignages (pas encore de contenu).

## Source

Ce document reprend le document de passation `CONTEXTE_PORTFOLIO.md` produit pendant la phase de conception. Les décisions prises depuis sont dans [decisions.md](decisions.md).
