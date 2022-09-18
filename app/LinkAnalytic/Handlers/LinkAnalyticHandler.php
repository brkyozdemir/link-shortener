<?php

namespace App\LinkAnalytic\Handlers;

use App\LinkAnalytic\Models\LinkAnalytic;
use App\ShortUrl\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class LinkAnalyticHandler
{
    private static function getQuery(): Builder
    {
        return LinkAnalytic::query();
    }

    public static function createLinkAnalyticsByShortUrl(ShortUrl $shortUrl, string $type): void
    {
        self::getQuery()->create([
            'type' => $type,
            'short_url_id' => $shortUrl->id,
        ]);
    }

    public static function getAnalyticsByShortUrl(ShortUrl $shortUrl): array
    {
        $dailyRedirection = $shortUrl
            ->linkAnalytics()
            ->where('created_at', '>', Carbon::now()->startOfDay())
            ->where('created_at', '<', Carbon::now()->endOfDay())
            ->count();

        $exitPageRedirection = $shortUrl
            ->linkAnalytics()
            ->where('type', LinkAnalytic::TYPE_EXIT_PAGE_REDIRECTION)
            ->count();

        return [
            'daily_redirection' => $dailyRedirection,
            'exit_page_refirection' => $exitPageRedirection,
        ];
    }
}
