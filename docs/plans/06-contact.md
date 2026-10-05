# 06 — Contact

**Statut** : À faire · **Prérequis** : 04 · **Bloquée par** : —

## Objectif
Rendre le formulaire de contact fonctionnel, protégé contre le spam, avec notification par e-mail.

## Références
- Specs : [contact-et-messages.md](../specs/contact-et-messages.md), [securite.md](../specs/securite.md)

## Livrables
- Route `POST /contact` + `Site\ContactController` + `ContactRequest`.
- Mailable `NewContactMessage` (Markdown, en file d'attente).
- Limiteur de débit `contact`.
- Route `/cv` + `Site\CvController`.

## Tâches
- [ ] Form Request avec règles et messages en français
- [ ] Pot de miel + délai minimal signé
- [ ] Limiteur de débit (3 / 10 min, 10 / jour par IP)
- [ ] Enregistrement du message (IP hachée)
- [ ] E-mail de notification avec `Reply-To`
- [ ] Message de confirmation et conservation des champs en cas d'erreur
- [ ] Téléchargement du CV avec nom lisible et comptage

## Critères d'acceptation
- Un message valide apparaît en base et l'e-mail arrive dans Mailpit.
- Un robot qui remplit le pot de miel ne crée rien.
- Le 4ᵉ envoi rapproché reçoit une erreur 429 avec un message compréhensible.

## Tests
- Voir la section « Tests attendus » de [contact-et-messages.md](../specs/contact-et-messages.md).
- `/cv` : 200 avec le bon nom de fichier, 404 sans CV, vue enregistrée.
