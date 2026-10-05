# 10 — Médias

**Statut** : À faire · **Prérequis** : 03, 07 · **Bloquée par** : —

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
- [ ] Déclarer les collections et conversions sur `Profile` et `Project`
- [ ] Correction d'orientation et suppression EXIF
- [ ] Composant d'image publique
- [ ] Composant d'envoi admin (validation type / taille)
- [ ] Texte alternatif et légende traduisibles
- [ ] Bibliothèque : liste, détails, « utilisée dans », suppression protégée
- [ ] Volume Docker persistant pour `storage/app/public`

## Critères d'acceptation
- Une photo de 5 Mo envoyée produit des fichiers WebP de quelques centaines de Ko au plus.
- Les pages publiques n'utilisent jamais l'original.
- Lighthouse ne signale ni image trop grande ni décalage de mise en page.

## Tests
- Envoi valide (conversions mises en file) ; type refusé ; taille refusée ; suppression refusée si l'image est utilisée.
