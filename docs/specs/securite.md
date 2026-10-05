# Sécurité

## Authentification
- Mots de passe hachés (`Hash::make`, algorithme par défaut de Laravel), 12 caractères minimum.
- Limitation des tentatives de connexion : 5 par e-mail + IP, blocage 15 minutes.
- Régénération de la session à la connexion, invalidation à la déconnexion.
- « Rester connecté » : jeton `remember_token` standard.
- Réinitialisation du mot de passe par lien à usage unique valable 60 minutes.
- Double authentification : V3.

## Autorisations
- Un seul rôle : administrateur. Toutes les routes `/admin/*` passent par le middleware `auth`.
- Les composants Livewire vérifient l'authentification à chaque action (pas seulement à l'affichage).
- Pas d'inscription publique : l'administrateur est créé par seed ou par la commande `admin:create`.

## Données entrantes
- Validation de chaque formulaire par Form Request ou règles Livewire.
- HTML de l'éditeur riche **nettoyé** à l'enregistrement (liste blanche de balises) avant affichage avec `{!! !!}`.
- Envois de fichiers : contrôle du type MIME réel et de la taille ; noms de fichiers régénérés.
- Formulaire de contact : voir [contact-et-messages.md](contact-et-messages.md).

## En-têtes et configuration
- HTTPS obligatoire en production, `SESSION_SECURE_COOKIE=true`, HSTS.
- En-têtes : `X-Content-Type-Options`, `Referrer-Policy`, `X-Frame-Options: DENY`, `Permissions-Policy`, HSTS en HTTPS (middleware `SecurityHeaders` et Caddy). La politique CSP est reportée en V2 (Livewire et Alpine demandent un réglage spécifique).
- `APP_DEBUG=false` en production ; secrets uniquement dans `.env`, jamais versionnés.

## Données personnelles
- Les IP des expéditeurs sont hachées.
- Les messages supprimés sont purgés après 30 jours.
