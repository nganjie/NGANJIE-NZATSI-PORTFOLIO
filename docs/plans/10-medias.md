# 10 — Médias

**Statut** : Terminé · **Prérequis** : 03, 07 · **Bloquée par** : —

## Objectif
Envoyer, optimiser et servir les images (et le CV) proprement, avec plusieurs tailles et chargement différé.

## Références
- Specs : [medias.md](../specs/medias.md)

## Livrables
- Conversions medialibrary (`thumb`, `md`, `lg`, `og`, WebP) en file d'attente.
- Composant Blade `<x-site.image>` qui produit `srcset`, `sizes`, `width`, `height`, `loading`.
- Composant Livewire d'envoi réutilisable (glisser-déposer, aperçu, progression).
- Écran `Admin\Media` (bibliothèque).

## Tâches
- [x] Déclarer les collections et conversions sur `Profile` et `Project`
- [x] Correction d'orientation et suppression EXIF
- [x] Composant d'image publique
- [x] Composant d'envoi admin (validation type / taille)
- [x] Texte alternatif et légende traduisibles
- [x] Bibliothèque : liste, détails, « utilisée dans », suppression protégée
- [x] Volume Docker persistant pour `storage/app/public`

## Critères d'acceptation
- Une photo de 5 Mo envoyée produit des fichiers WebP de quelques centaines de Ko au plus.
- Les pages publiques n'utilisent jamais l'original.
- Lighthouse ne signale ni image trop grande ni décalage de mise en page.

## Tests
- Envoi valide (conversions mises en file) ; type refusé ; taille refusée ; suppression refusée si l'image est utilisée.

## Notes de réalisation (2026-10-05)

- Conversions `thumb` / `md` / `lg` en WebP, `og` 1200×630 pour la couverture et l'image de partage.
- Dimensions enregistrées à l'envoi (`width` / `height`) pour éviter les décalages de mise en page.
- La bibliothèque permet de modifier le texte alternatif et la légende, et de supprimer une image (avec confirmation) ; l'ajout se fait depuis les fiches projet et le profil.
