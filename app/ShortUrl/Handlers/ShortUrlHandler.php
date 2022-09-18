<?php

namespace App\ShortUrl\Handlers;

use App\Models\User;
use App\ShortUrl\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ShortUrlHandler
{
    private static function getQuery(): Builder
    {
        return ShortUrl::query();
    }

    public static function getById(int $id): ?ShortUrl
    {
        return self::getQuery()->where('id', $id)->first();
    }

    public static function create(User $user, array $params): ShortUrl
    {
        $params['expiration_time'] = Carbon::now()->addHour();
        $shortUrl = $user->shortUrls()->create($params);

        if (is_null($shortUrl->slug)) {
            $shortUrl->slug = Str::random(4);
            $shortUrl->save();
        }

        return $shortUrl;
    }

    public static function listByUser(User $user): Collection
    {
        return $user->shortUrls()->get();
    }

    public static function update(int $id, array $params): int
    {
        return self::getQuery()
            ->findOrFail($id)
            ->update($params);
    }

    public static function getBySlug(string $slug): ShortUrl
    {
        return self::getQuery()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public static function getExitPageQuote(): string
    {
        $url = config('business.exit_page_url');
        return Http::get($url)->json('quote');
    }
}
