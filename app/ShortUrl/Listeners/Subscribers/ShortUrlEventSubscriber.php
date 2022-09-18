<?php

namespace App\ShortUrl\Listeners\Subscribers;

use App\LinkAnalytic\Handlers\LinkAnalyticHandler;
use App\LinkAnalytic\Models\LinkAnalytic;
use App\ShortUrl\Events\E_ShortUrlRedirected;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShortUrlEventSubscriber implements ShouldQueue
{
    public function onShortUrlRedirected(E_ShortUrlRedirected $event): void
    {
        $shortUrl = $event->shortUrl;
        $type = $event->type;

        match ($type) {
            LinkAnalytic::TYPE_DAILY_REDIRECTION =>
            LinkAnalyticHandler::createLinkAnalyticsByShortUrl($shortUrl, LinkAnalytic::TYPE_DAILY_REDIRECTION),

            LinkAnalytic::TYPE_EXIT_PAGE_REDIRECTION =>
            LinkAnalyticHandler::createLinkAnalyticsByShortUrl($shortUrl, LinkAnalytic::TYPE_EXIT_PAGE_REDIRECTION),

            default => null,
        };
    }

    public function subscribe($events)
    {
        $events->listen(
            E_ShortUrlRedirected::class,
            [static::class, 'onShortUrlRedirected']
        );
    }
}
