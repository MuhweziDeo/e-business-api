<?php


namespace App\Helpers;

use App\User;

class JWTHelper
{

    /**
     * @param $credentials
     * @return string token
     */
    static function generateToken($credentials)
    {
        return auth()->attempt($credentials);
    }

    static function decodeToken()
    {
        return auth()->user();
    }

    static function generateTokenFromUser(User $user)
    {
        return auth()->login($user);
    }

}
