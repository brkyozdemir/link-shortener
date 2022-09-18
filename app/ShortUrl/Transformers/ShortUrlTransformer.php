<?php

namespace App\ShortUrl\Transformers;

use App\ShortUrl\Models\ShortUrl;
use League\Fractal\TransformerAbstract;

class ShortUrlTransformer extends TransformerAbstract
{
    public function transform(ShortUrl $shortUrl): array
    {
        return [
            'id' => $shortUrl->id,
            'name' => $shortUrl->name,
            'link' => $shortUrl->link,
            'slug' => $shortUrl->slug,
            'exit_page' => $shortUrl->exit_page,
            'expiration_time' => $shortUrl->expiration_time,
        ];
    }
}
