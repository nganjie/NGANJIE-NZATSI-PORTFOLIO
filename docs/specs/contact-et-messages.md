# Contact et messages

## Formulaire public

| Champ | Règles |
|---|---|
| Type de demande | obligatoire ; `job` (Offre d'emploi ou de stage), `freelance` (Mission freelance), `other` (Autre demande) |
| Nom | obligatoire, 2 à 100 caractères |
| E-mail | obligatoire, adresse valide (`email:rfc,dns` en production) |
| Message | obligatoire, 10 à 5 000 caractères |
| `website` | **pot de miel** : champ caché aux humains (hors écran, `tabindex="-1"`, `autocomplete="off"`) ; s'il est rempli, la requête est ignorée silencieusement (réponse de succès, rien n'est enregistré) |

Protections supplémentaires :
- **Limitation de débit** : 3 envois par IP toutes les 10 minutes, 10 par jour.
- **Délai minimal** : un envoi moins de 3 secondes après l'affichage de la page est ignoré (horodatage signé dans un champ caché).
- Protection CSRF standard de Laravel.

## Après l'envoi

1. Le message est enregistré dans `messages` (IP hachée).
2. Un e-mail de notification part **en file d'attente** vers l'adresse définie dans les paramètres, avec `Reply-To` = l'e-mail de l'expéditeur.
3. Retour sur `/#contact` avec un message de confirmation : « Merci, votre message a bien été envoyé. Je vous réponds sous 48 heures. »
4. Les champs sont conservés en cas d'erreur de validation.

Sans JavaScript, le formulaire fonctionne en envoi classique. Avec JavaScript, l'envoi peut se faire sans recharger la page (amélioration progressive, facultatif en V1).

## Boîte de réception

Voir [administration.md](administration.md#messages).

## Tests attendus

- Envoi valide → message enregistré + e-mail mis en file.
- Pot de miel rempli → rien n'est enregistré, réponse de succès.
- 4ᵉ envoi en 10 minutes → erreur 429.
- Champs invalides → erreurs de validation, rien n'est enregistré.
