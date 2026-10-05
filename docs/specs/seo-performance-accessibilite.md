# Référencement, performance, accessibilité

## Référencement
- `<title>` et `<meta name="description">` par page : valeurs SEO du projet, sinon valeurs par défaut des paramètres.
- Balises Open Graph et Twitter Card (titre, description, image `og`).
- URL canoniques ; `sitemap.xml` (accueil, liste, projets publiés) ; `robots.txt` qui exclut `/admin`.
- Données structurées JSON-LD : `Person` sur l'accueil, `CreativeWork` sur chaque projet.
- Un seul `<h1>` par page, hiérarchie de titres respectée.

## Performance (cibles)
- Lighthouse mobile ≥ 90 en performance, ≥ 95 en accessibilité, bonnes pratiques et SEO.
- Poids de l'accueil < 500 Ko hors images différées ; JavaScript public < 30 Ko.
- Polices : Schibsted Grotesk et Figtree auto-hébergées en WOFF2, sous-ensemble latin, `font-display: swap`, préchargement de la police des titres.
- Images : voir [medias.md](medias.md).
- Cache : requêtes de l'accueil en cache (vidé à chaque modification dans l'admin), `php artisan optimize` en production, compression gzip/brotli par Nginx, en-têtes de cache longs pour les fichiers versionnés par Vite.

## Accessibilité
- Vrais `<a>` et `<button>` ; libellé `<label>` sur chaque champ ; `aria-label` sur les boutons sans texte.
- Contrastes ≥ 4,5:1 (texte noir sur vert citron, texte blanc sur violet ; texte secondaire `#55545A` sur fond clair).
- Navigation complète au clavier, focus visible (contour vert citron).
- Lien d'évitement « Aller au contenu ».
- `prefers-reduced-motion` : pas d'inclinaison animée ni de soulèvement au survol.
- Formulaires : erreurs reliées aux champs par `aria-describedby`.
