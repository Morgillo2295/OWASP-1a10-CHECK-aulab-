<?php

namespace App\Services;

use DOMDocument;
use Illuminate\Database\Eloquent\Collection;

class HtmlFilterService
{
    public function filterHtml($html)
    {
        // Creazione di un oggetto DOMDocument
        $doc = new DOMDocument();
        
        // Carica il testo HTML
        $doc->loadHTML($html);
        
        // Trova tutti i tag script nel documento
        $scriptTags = $doc->getElementsByTagName('script');
        
        // Rimuovi i tag script dal documento
        foreach ($scriptTags as $scriptTag) {
            $scriptTag->parentNode->removeChild($scriptTag);
        }
        
        // Ottieni il contenuto elaborato
        return $doc->saveHTML();
    }
    
    public function filterHtmlCollectionByField(Collection $collection, string $key)
    {
        return $collection->map(function ($item) use($key){
            $item->$key = $this->filterHtml($item->$key);
            return $item;
        });
    }
}
