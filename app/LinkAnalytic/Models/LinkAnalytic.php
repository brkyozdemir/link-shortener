<?php

namespace App\LinkAnalytic\Models;

use App\ShortUrl\Models\ShortUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $redirection_count
 * @property int $exit_page_redirection_count
 * @property int $short_url_id
 */
class LinkAnalytic extends Model
{
    protected $table = 'link_analytics';

    const TYPE_EXIT_PAGE_REDIRECTION = 'exit_page_redirection';
    const TYPE_DAILY_REDIRECTION = 'redirection';

    #region Relations

    public function shortUrl(): BelongsTo
    {
        return $this->belongsTo(ShortUrl::class, 'short_url_id');
    }

    #endregion

    protected $fillable = [
        'short_url_id',
        'redirection_count',
        'exit_page_count',
        'type',
    ];
}
