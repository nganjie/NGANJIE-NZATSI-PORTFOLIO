# Documentation du projet

Portfolio administrable de Nganjie Nzatsi. Ce dossier contient tout ce qu'il faut pour planifier, spécifier et concevoir le projet avant et pendant le développement.

## Organisation

| Dossier | Contenu | Question à laquelle il répond |
|---|---|---|
| [`specs/`](specs/) | Spécifications fonctionnelles et techniques | **Quoi** construire, et selon quelles règles |
| [`plans/`](plans/) | Plans d'exécution, un fichier par étape | **Comment** et **dans quel ordre** le construire |
| [`designs/`](designs/) | Identité visuelle, inventaire des écrans, maquettes | **À quoi** ça doit ressembler |

## Comment s'en servir

1. Avant une étape : lire son plan dans `plans/`, puis les specs et les designs qu'il référence.
2. Pendant l'étape : cocher les tâches du plan au fur et à mesure.
3. À la fin : vérifier les critères d'acceptation, mettre le statut du plan à « Terminé » et mettre à jour la [feuille de route](plans/00-feuille-de-route.md).
4. Toute décision nouvelle est ajoutée au [journal des décisions](specs/decisions.md). Toute question sans réponse va dans les [questions ouvertes](specs/questions-ouvertes.md).

## Conventions

- **Langue** : français pour la documentation, l'interface et les contenus. Le code (classes, variables, tables) est en anglais.
- **Numérotation** : les plans sont numérotés dans l'ordre d'exécution (`01-…`, `02-…`). Les specs et les designs ne sont pas numérotés.
- **Statuts** d'un plan : `À faire` · `En cours` · `Terminé` · `Bloqué` (avec la raison).
- **Liens** : chaque plan pointe vers les specs et les designs qu'il met en œuvre ; chaque spec renvoie à la décision qui la justifie.
- **Placeholders** : une information manquante s'écrit entre crochets en majuscules, par exemple `[LIEN LINKEDIN]`, et doit figurer dans les questions ouvertes.

## Points d'entrée

- [Feuille de route](plans/00-feuille-de-route.md) : toutes les étapes et leur statut.
- [Contexte du projet](specs/contexte.md) : objectif, public, périmètre.
- [Architecture](specs/architecture.md) : stack et organisation du code.
- [Maquette Claude Design](designs/README.md) : les 9 écrans validés.
