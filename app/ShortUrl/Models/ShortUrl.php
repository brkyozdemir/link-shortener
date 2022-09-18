<?php

namespace App\ShortUrl\Models;

use App\LinkAnalytic\Models\LinkAnalytic;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $link
 * @property string $name
 * @property string $slug
 * @property boolean $exit_page
 * @property mixed $expiration_time
 * @property LinkAnalytic $linkAnalytics
 */
class ShortUrl extends Model
{
    protected $table = 'short_urls';

    #region Relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function linkAnalytics(): HasMany
    {
        return $this->hasMany(LinkAnalytic::class, 'short_url_id');
    }

    #endregion

    protected $fillable = [
        'name',
        'slug',
        'link',
        'user_id',
        'exit_page',
        'expiration_time',
    ];
}
