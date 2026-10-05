# Administration

Maquettes : [designs/ecrans.md](../designs/ecrans.md) — écrans « Connexion », « Tableau de bord », « Projets », « Édition d'un projet », « Messages ».

## Règles communes

- Toutes les routes sous `/admin` sauf la connexion et le mot de passe oublié exigent une session authentifiée.
- Mise en page : barre latérale noire (logo, menu, badge des messages non lus, « Voir le site », « Se déconnecter ») et zone de contenu claire. Sous 900 px, la barre latérale passe au-dessus du contenu.
- Chaque enregistrement affiche un message de confirmation ; chaque suppression demande une confirmation.
- Les formulaires valident côté serveur et affichent les erreurs sous chaque champ.
- Les champs traduisibles ont des onglets **Français / English**. En V1, seul le français est obligatoire ; l'onglet anglais est disponible mais facultatif.
- Les listes ordonnables se trient par glisser-déposer avec une poignée, et aussi avec des boutons « monter / descendre » pour le clavier.

## Connexion

- E-mail + mot de passe, case « Rester connecté », lien « Mot de passe oublié ».
- 5 échecs par e-mail + IP → blocage 15 minutes, message explicite.
- Mot de passe oublié : lien par e-mail, valable 60 minutes. Message identique que l'e-mail existe ou non.
- Après connexion : `last_login_at` mis à jour, redirection vers le tableau de bord.

## Tableau de bord (V1)

- Indicateurs : messages non lus, projets publiés, brouillons, date du CV.
- Derniers messages (5) avec lien vers la boîte de réception.
- État du site : mention de disponibilité affichée ou non, nombre de projets à la une, photo et CV présents ou manquants, avec un bouton « Compléter le profil ».
- Encadré « V2 » à la place des statistiques de visites (visites du mois, vues des projets, téléchargements du CV, visites par jour, projets les plus vus).

## Profil et CV

Formulaire de la ligne unique `profiles` : photo (recadrage carré), nom affiché, titre, titre d'accueil et partie surlignée, bio, ville, disponibilité (interrupteur + libellé), e-mail, WhatsApp, GitHub, LinkedIn, projet phare (liste des projets publiés), fichier CV (PDF, 5 Mo max ; met à jour `cv_updated_at`).

## Projets

- **Liste** : recherche par titre, filtres type et statut, colonnes ordre (poignée), projet (vignette couleur, titre, slug), type, statut, interrupteur « À la une », actions « Modifier » et « Aperçu ». Bouton « + Nouveau projet ».
- **Édition** (création et modification) :
  - Informations : titre, adresse de la page (slug, généré puis modifiable, unique), résumé, rôle, contexte, période, lien du site en ligne, lien du dépôt.
  - Étude de cas : éditeur riche (titres, gras, italique, listes, liens, images), tâches « Ce que j'ai fait » (ajout, modification, suppression, ordre), enseignement retenu, résultats.
  - Galerie : envoi multiple, légende et texte alternatif par image, ordre.
  - Référencement : titre SEO (60 caractères), description SEO (160 caractères), aperçu du résultat de recherche.
  - Colonne latérale : statut, type, à la une, image de couverture, couleur d'accent (pastilles), technologies (étiquettes avec suppression + liste pour ajouter).
  - Zone sensible : supprimer le projet.
  - Boutons « Aperçu » (ouvre la page publique, même en brouillon) et « Enregistrer ».
- Passer en « Publié » remplit `published_at` la première fois.

## Compétences, technologies, parcours, méthode

Même modèle d'écran pour les quatre : liste ordonnable + formulaire de création/modification dans un panneau latéral + suppression avec confirmation.

| Écran | Champs |
|---|---|
| Compétences | titre, description, étiquettes (saisie par étiquette) |
| Technologies | nom, catégorie, « afficher sur l'accueil » (8 maximum, avertissement au-delà) |
| Parcours | type, organisme, intitulé, date de début, date de fin ou « en cours », libellé de date libre, points clés, poste actuel (un seul à la fois) |
| Méthode | titre, texte |

## Messages

- Onglets « Boîte de réception » et « Archivés », compteur de non lus.
- Liste : point violet si non lu, nom, date, type, extrait. Ouvrir un message le marque comme lu.
- Détail : type, nom, e-mail, date, contenu complet ; actions « Marquer non lu », « Archiver » / « Désarchiver », « Supprimer », « Répondre par e-mail » (`mailto:` avec l'objet pré-rempli « Re : votre message sur nganjie »).

## Médias

- Bibliothèque des images envoyées : vignette, nom, dimensions, poids, texte alternatif, utilisée dans (projets).
- Envoi par glisser-déposer ; suppression refusée si l'image est utilisée.

## Paramètres

- Référencement par défaut : titre, description, image de partage.
- Sections de l'accueil affichées ou masquées.
- E-mail qui reçoit les notifications de contact.
