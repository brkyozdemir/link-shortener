<?php

namespace App\Auth\Handlers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthHandler
{
    public static function signup(array $params): User
    {
        return User::create($params);
    }

    public static function getGrantClientSecret()
    {
        return DB::table('oauth_clients')
            ->where('id', 2)
            ->pluck('secret')
            ->first();
    }
}
