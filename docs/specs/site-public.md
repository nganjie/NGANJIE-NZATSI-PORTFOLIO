# Site public

Maquettes : [designs/ecrans.md](../designs/ecrans.md) — écrans « Accueil », « Liste des projets », « Détail d'un projet », « Accueil mobile ».

## Règles communes

- Rendu entièrement côté serveur (Blade) ; JavaScript limité au menu mobile et à l'amélioration du formulaire.
- Tout le contenu vient de la base ; si une donnée manque, l'élément est masqué (jamais de texte de remplacement en production).
- Une section de l'accueil masquée dans les paramètres n'apparaît ni dans la page ni dans le menu.
- Responsive : contenu de 1180 px maximum, marges de 24 px (16 px sur mobile), grilles sur une colonne sous 900 px.

## En-tête et pied de page

- **En-tête** : logo (lien vers l'accueil), menu en pastilles (Projets, Compétences, Parcours, Méthode, Contact) pointant vers les ancres de l'accueil, bouton e-mail (`mailto:`). Sous 900 px : bouton menu qui ouvre un panneau plein écran (accessible au clavier, `aria-expanded`).
- **Pied de page** : logo, navigation, réseaux, lien CV, mention © année courante, lien discret « Administration » vers `/admin/connexion`.

## Accueil (`/`)

| Section | Contenu | Source |
|---|---|---|
| Haut de page | Titre (`tagline` + partie surlignée), photo ronde, aperçu du projet phare, mention de disponibilité (si `is_available`), bio, boutons « Découvrir mes projets » (#projets) et « Me recruter » (#contact), liens GitHub / LinkedIn / WhatsApp, « Télécharger le CV (PDF) » | `profiles` |
| Projets (#projets) | Projets publiés **et** à la une, triés par `position` (3 recommandés) : type, titre, contexte, rôle, stack, grande image. Bouton « Voir tous les projets » | `projects` |
| Compétences (#competences) | 4 domaines : numéro, titre, description, étiquettes | `skill_domains` |
| Parcours (#parcours) | Lignes date / organisme / intitulé / points clés ; la ligne `is_current` sur fond violet pleine largeur | `experiences` |
| Technologies | Grille de 8 technologies (`show_on_home`) avec catégorie | `technologies` |
| Méthode (#methode) | 4 cartes numérotées, légèrement inclinées | `process_steps` |
| Contact (#contact) | Formulaire + e-mail direct ; voir [contact-et-messages.md](contact-et-messages.md) | `profiles` |

Le lien WhatsApp est `https://wa.me/<numéro sans +>`. Un lien vide (LinkedIn non renseigné) est masqué.

## Liste des projets (`/projets`)

- Tous les projets publiés, triés par `position`.
- Filtres : Tous / Professionnel / Personnel / Académique, avec le nombre de projets par filtre. Un filtre sans projet est masqué.
- Le filtre se passe en paramètre d'URL (`/projets?type=personnel`) pour être partageable et fonctionner sans JavaScript.
- Carte : image (couleur d'accent + filet intérieur), type, titre, résumé, stack. Toute la carte est un lien.

## Détail d'un projet (`/projets/{slug}`)

- 404 si le projet n'existe pas ou n'est pas publié (sauf pour l'administrateur connecté : aperçu avec un bandeau « Brouillon »).
- Fil d'Ariane : Accueil / Projets / Titre.
- Contenu dans l'ordre : étiquettes (type + catégories des technologies), titre, résumé, bouton « Voir le site en ligne » (si `demo_url`), lien vers le dépôt (si `repository_url`), image de couverture, 4 fiches (Rôle, Contexte, Stack, Période), étude de cas, « Ce que j'ai fait » (tâches numérotées), galerie avec légendes, enseignement retenu, résultats, bloc « Projet suivant ».
- Les blocs vides sont masqués.
- « Projet suivant » : le projet publié suivant par `position`, en boucle.
- Chaque affichage enregistre une ligne dans `page_views` (hors administrateur connecté et robots connus).

## Téléchargement du CV (`/cv`)

- Renvoie le PDF avec un nom lisible : `CV-Nganjie-Nzatsi.pdf`.
- Enregistre une vue `path = /cv`. 404 si aucun CV n'est envoyé (le lien est alors masqué partout).
