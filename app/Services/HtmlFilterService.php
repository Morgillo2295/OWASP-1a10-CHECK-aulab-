<?php

namespace App\Services;

use DOMDocument;
use Illuminate\Database\Eloquent\Collection;

class HtmlFilterService
{
    public function filterHtml(string $html): string
    {
        libxml_use_internal_errors(true);

        if (version_compare(PHP_VERSION, '8.0.0', '<')) {
            libxml_disable_entity_loader(true);
        }

        $doc = new DOMDocument();
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach (['script', 'iframe', 'object', 'embed', 'link', 'style'] as $tag) {
            $nodes = $doc->getElementsByTagName($tag);
            for ($i = $nodes->length - 1; $i >= 0; $i--) {
                $node = $nodes->item($i);
                if ($node && $node->parentNode) {
                    $node->parentNode->removeChild($node);
                }
            }
        }

        foreach ($doc->getElementsByTagName('*') as $node) {
            if (! $node->hasAttributes()) {
                continue;
            }

            $attributes = [];
            foreach ($node->attributes as $attribute) {
                $attributes[$attribute->name] = $attribute->value;
            }

            foreach ($attributes as $name => $value) {
                $lowerName = strtolower($name);
                $lowerValue = strtolower(trim($value));

                if (str_starts_with($lowerName, 'on')) {
                    $node->removeAttribute($name);
                    continue;
                }

                if (in_array($lowerName, ['src', 'href', 'formaction', 'xlink:href'], true)) {
                    if (str_starts_with($lowerValue, 'javascript:') || str_starts_with($lowerValue, 'data:')) {
                        $node->removeAttribute($name);
                    }
                }
            }
        }

        $clean = $doc->saveHTML();
        libxml_clear_errors();

        return $clean;
    }

    public function filterHtmlCollectionByField(Collection $collection, string $key)
    {
        return $collection->map(function ($item) use ($key) {
            $item->$key = $this->filterHtml((string) $item->$key);
            return $item;
        });
    }
}
