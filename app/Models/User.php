<?php

namespace App\Models;

use App\ShortUrl\Models\ShortUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property int $id
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    #region Relations

    public function shortUrls(): HasMany
    {
        return $this->hasMany(ShortUrl::class, 'user_id');
    }

    #endregion

    public static function create(array $attributes): self
    {
        $user = new self();
        $attributes['password'] = self::hashPassword($attributes['password']);
        return $user::query()->create($attributes);
    }

    public static function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
