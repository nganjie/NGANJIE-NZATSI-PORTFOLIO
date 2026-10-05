<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

/**
 * Cleans the HTML produced by the rich text editor before it is stored.
 */
class RichText
{
    public static function sanitize(?string $html): ?string
    {
        if (blank(strip_tags((string) $html))) {
            return null;
        }

        $config = (new HtmlSanitizerConfig)
            ->allowElement('p')
            ->allowElement('div')
            ->allowElement('br')
            ->allowElement('strong')
            ->allowElement('b')
            ->allowElement('em')
            ->allowElement('i')
            ->allowElement('del')
            ->allowElement('ul')
            ->allowElement('ol')
            ->allowElement('li')
            ->allowElement('h2')
            ->allowElement('h3')
            ->allowElement('blockquote')
            ->allowElement('pre')
            ->allowElement('code')
            ->allowElement('a', ['href', 'title'])
            ->allowLinkSchemes(['https', 'http', 'mailto'])
            ->forceAttribute('a', 'rel', 'noopener')
            ->withMaxInputLength(100_000);

        return trim((new HtmlSanitizer($config))->sanitize((string) $html));
    }
}
