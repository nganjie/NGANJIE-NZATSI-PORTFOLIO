# Inventaire des écrans

Source : canevas Claude Design v3 (voir [README.md](README.md)). Fichier source de chaque écran dans [maquette/](maquette/).

## Site public

| Écran | Fichier | Largeur | Plan | Contenu |
|---|---|---|---|---|
| Accueil | `Main.dc.html` | 1440 px, fluide | 04 | En-tête, haut de page, projets à la une, compétences, parcours, technologies, méthode, contact, pied de page. Réglage « disponible » pour afficher / masquer la mention. |
| Liste des projets | `Projets.dc.html` | 1440 px, fluide | 05 | Fil d'Ariane, titre, filtres avec compteurs (fonctionnels), grille de cartes. |
| Détail d'un projet | `Projet.dc.html` | 1440 px, fluide | 05 | Étiquettes, titre, résumé, lien en ligne, couverture, fiches, contexte, réalisations numérotées, galerie, enseignement, résultats, projet suivant. |
| Accueil mobile | `Mobile.dc.html` | 390 px | 04 | Version mobile de l'accueil avec menu ouvrable. |

## Administration

| Écran | Fichier | Plan | Contenu |
|---|---|---|---|
| Connexion | `AdminConnexion.dc.html` | 07 | Panneau de marque à gauche, formulaire à droite, règle de blocage. |
| Tableau de bord | `AdminTableau.dc.html` | 08 | 4 indicateurs, encadré V2, derniers messages, état du site. |
| Projets | `AdminProjets.dc.html` | 09 | Recherche, filtres, tableau avec poignée, vignette, statut, interrupteur « À la une ». |
| Édition d'un projet | `AdminProjet.dc.html` | 09 | Onglets FR/EN, informations, étude de cas (éditeur), tâches, galerie, référencement, colonne publication / couverture / couleur / technologies / suppression. |
| Messages | `AdminMessages.dc.html` | 12 | Boîte de réception / archivés, liste, détail, actions. |

## Écrans non dessinés

À construire en suivant les écrans existants (même barre latérale, mêmes cartes et champs) ; les dessiner dans le canevas si un doute apparaît.

| Écran | Modèle à suivre |
|---|---|
| Profil et CV | Colonne principale de « Édition d'un projet » |
| Compétences, Technologies, Parcours, Méthode | Tableau de « Projets » + panneau latéral d'édition |
| Médias | Grille de la galerie de « Édition d'un projet » en pleine page |
| Paramètres | Cartes de « Édition d'un projet » |
| Mot de passe oublié / réinitialisation | « Connexion » |
| Page 404 / 500 publique | En-tête + grand titre en majuscules + bouton retour |
| États vides et erreurs de formulaire | Composants `empty-state` et `field` |
