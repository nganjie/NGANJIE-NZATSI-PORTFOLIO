import 'trix';

/**
 * Admin only: images are managed in the gallery, not inside the rich text.
 */
document.addEventListener('trix-file-accept', (event) => event.preventDefault());
