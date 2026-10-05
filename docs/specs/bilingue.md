# Bilingue FR/EN

## En V1 (préparation)

- Tous les champs de contenu sont traduisibles (marqués **T** dans [modele-de-donnees.md](modele-de-donnees.md)), stockés en JSON grâce à `spatie/laravel-translatable` (D07).
- Langue par défaut et de repli : `fr`.
- L'admin montre des onglets Français / English ; seul le français est obligatoire.
- Le site public n'affiche que le français.
- Les libellés d'interface passent tous par `__()` avec des fichiers `lang/fr/*.php`, pour faciliter l'ajout de `lang/en`.

## En V2

- URL : `/` et `/projets/...` en français, `/en/` et `/en/projects/...` en anglais. Le slug reste commun.
- Sélecteur de langue dans l'en-tête ; balises `hreflang` et `<html lang>` adaptées.
- Si un champ n'est pas traduit, on affiche le français.
