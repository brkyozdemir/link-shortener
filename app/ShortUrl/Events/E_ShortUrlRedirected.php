<?php

namespace App\ShortUrl\Events;

use App\ShortUrl\Models\ShortUrl;

class E_ShortUrlRedirected
{
    public ShortUrl $shortUrl;
    public string $type;

    public function __construct(ShortUrl $shortUrl, string $type)
    {
        $this->shortUrl = $shortUrl;
        $this->type = $type;
    }
}
