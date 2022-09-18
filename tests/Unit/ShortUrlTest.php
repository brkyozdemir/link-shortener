<?php

namespace Unit;

use App\Models\User;
use App\ShortUrl\Handlers\ShortUrlHandler;
use App\ShortUrl\Models\ShortUrl;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    public function test_get_by_id()
    {
        $shortUrl = ShortUrlHandler::getById(1);

        $this->assertEquals(get_class($shortUrl), ShortUrl::class);
    }

    public function test_create_short_url()
    {
        $user = User::query()->latest()->first();
        $params = [
            'name' => 'name',
            'slug' => 'slug',
            'link' => 'link',
            'exit_page' => true,
        ];

        $shortUrl = ShortUrlHandler::create($user, $params);

        $this->assertModelExists($shortUrl);
    }
}
