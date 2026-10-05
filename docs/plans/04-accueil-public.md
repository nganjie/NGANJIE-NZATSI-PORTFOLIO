# 04 — Accueil public

**Statut** : À faire · **Prérequis** : 02, 03 · **Bloquée par** : Q4 (mention de disponibilité)

## Objectif
Construire la page d'accueil complète à partir des données, conforme à la maquette, sur ordinateur et sur mobile.

## Références
- Specs : [site-public.md](../specs/site-public.md#accueil-)
- Designs : [ecrans.md](../designs/ecrans.md) — « Accueil », « Accueil mobile »

## Livrables
- Route `/` + `Site\HomeController`.
- Vue `site/home.blade.php` découpée en sections (`site/home/hero`, `projects`, `skills`, `experience`, `technologies`, `process`, `contact`).
- Requêtes optimisées (chargement anticipé, pas de N+1) et mise en cache.

## Tâches
- [ ] Contrôleur : chargement du profil, projets à la une, domaines, parcours, technologies de l'accueil, étapes, paramètres de sections
- [ ] Haut de page : titre avec surlignage, photo, formes décoratives, aperçu du projet phare, disponibilité conditionnelle, boutons, liens sociaux, CV
- [ ] Section projets à la une (image de couleur si pas de capture)
- [ ] Section compétences (fond noir)
- [ ] Section parcours (ligne actuelle violette)
- [ ] Section technologies (grille de 8)
- [ ] Section méthode (cartes inclinées)
- [ ] Section contact (formulaire visuel ; l'envoi est fait à l'étape 06)
- [ ] Masquage des sections désactivées et des liens vides
- [ ] Menu mobile
- [ ] Cache de la page vidé par les événements `saved` / `deleted` des modèles concernés

## Critères d'acceptation
- La page correspond à la maquette à 1440 px et à 390 px.
- Modifier une donnée en base change l'affichage (après vidage du cache).
- Désactiver la disponibilité masque la mention.
- Nombre de requêtes SQL sur l'accueil ≤ 10.

## Tests
- `GET /` répond 200 et affiche le nom, le titre et les projets à la une.
- Un projet brouillon ou non à la une n'apparaît pas.
- La mention de disponibilité suit `is_available`.
- Une section masquée n'apparaît ni dans la page ni dans le menu.
