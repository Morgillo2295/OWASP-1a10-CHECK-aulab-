<?php

use Livewire\Component;

 class ArticleimageAnteprima extends Component
{
    public $imageUrl ='';
    public $imageData ='';
    public $isLoading = false;
    
  public function updatedImageUrl()
{
    $this->imageData = '';
    $this->isLoading = false;

    if (!$this->imageUrl) {
        return;
    }

    $this->isLoading = true;

    try {
        $url = $this->imageUrl;

        // 1. URL validation
        $parsed = parse_url($url);
        if (!$parsed || !isset($parsed['scheme'], $parsed['host'])) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        // 2. Only HTTPS allowed
        if (strtolower($parsed['scheme']) !== 'https') {
            throw new \InvalidArgumentException('Only HTTPS URLs are allowed');
        }

        // 3. Whitelist allowed domains (if applicable)
        // $allowedDomains = [
        //     'cdn.example.com',
        //     'images.example.com',
        // ];
        // if (!in_array(strtolower($parsed['host']), $allowedDomains, true)) {
        //     throw new \InvalidArgumentException('Domain not allowed');
        // }

        // 4. Resolve IP and block private/localhost addresses
        $ip = gethostbyname($parsed['host']);
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            throw new \InvalidArgumentException('Private/localhost addresses are not allowed');
        }

        // 5. Short timeout and no redirect
        $response = Http::timeout(5)
            ->withOptions([
                'allow_redirects' => false,
                'verify' => true,
                'max_redirects' => 0,
            ])
            ->get($url);

        // 6. Content-Type check
        $contentType = $response->header('Content-Type');
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array(strtolower($contentType), $allowedTypes, true)) {
            throw new \InvalidArgumentException('Content type not allowed');
        }

        // 7. Response size limit (e.g. 1MB)
        $body = $response->body();
        if (strlen($body) > 1024 * 1024) {
            throw new \InvalidArgumentException('Risposta troppo grande');
        }

        $this->imageData = 'data:' . $contentType . ';base64,' . base64_encode($body);
    } catch (\Exception $e) {
        $this->addError('imageUrl', 'Error loading image: ' . $e->getMessage());
    } finally {
        $this->isLoading = false;
    }
}
}
?>

<div>
    {{-- Order your soul. Reduce your wants. - Augustine --}}
</div>