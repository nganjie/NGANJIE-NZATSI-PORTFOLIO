# Feuille de route

Chaque étape a son plan détaillé. Une étape ne commence que lorsque ses prérequis sont terminés et ses questions bloquantes résolues.

| N° | Étape | Prérequis | Bloquée par | Statut |
|---|---|---|---|---|
| 01 | [Mise en place](01-mise-en-place.md) | — | — | Terminé |
| 02 | [Thème et composants de base](02-theme-et-composants.md) | 01 | — | Terminé |
| 03 | [Modèle de données et seed](03-modele-de-donnees-et-seed.md) | 01 | — | Terminé |
| 04 | [Accueil public](04-accueil-public.md) | 02, 03 | Q4 | Terminé |
| 05 | [Pages projets publiques](05-pages-projets.md) | 04 | Q6 | Terminé |
| 06 | [Contact](06-contact.md) | 04 | — | Terminé |
| 07 | [Admin : authentification et mise en page](07-admin-authentification.md) | 02, 03 | Q1 | Terminé |
| 08 | [Admin : tableau de bord, profil et CV](08-admin-tableau-de-bord-et-profil.md) | 07 | — | Terminé |
| 09 | [Admin : projets](09-admin-projets.md) | 07, 10 | Q5 | Terminé |
| 10 | [Médias](10-medias.md) | 03, 07 | — | Terminé |
| 11 | [Admin : compétences, technologies, parcours, méthode](11-admin-contenus.md) | 07 | — | Terminé |
| 12 | [Admin : messages et paramètres](12-admin-messages-et-parametres.md) | 06, 07 | — | Terminé |
| 13 | [Référencement, performance, accessibilité](13-seo-performance-accessibilite.md) | 04, 05 | — | Terminé |
| 14 | [Déploiement](14-deploiement.md) | toutes | Q2, Q3 | En cours : tout est prêt sauf le domaine et le serveur |

Fin de la **V1** = étapes 01 à 14 terminées. **État au 2026-10-05 : étapes 01 à 13 terminées, 14 prête à exécuter dès que le domaine et l'hébergement sont choisis.**

## Ordre conseillé

```
01 ─┬─ 02 ─┬─ 04 ─┬─ 05 ─┬─ 13 ─┐
    │      │      └─ 06 ─┤      │
    └─ 03 ─┤             │      ├─ 14
           └─ 07 ─┬─ 08  │      │
                  ├─ 10 ─ 09    │
                  ├─ 11         │
                  └─ 12 ────────┘
```

On commence par le site public (01 → 06), ce qui permet de montrer un résultat tôt, puis l'administration (07 → 12), puis la finition et la mise en ligne (13, 14).

## Versions suivantes

- [V2 et V3](20-versions-suivantes.md) : bilingue, statistiques, thème sombre, blog, témoignages, double authentification, sauvegardes.

## Modèle de plan

Chaque plan suit [_modele.md](_modele.md).
