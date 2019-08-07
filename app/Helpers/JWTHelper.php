<?php


namespace App\Helpers;


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

    static function decodeToken($data)
    {

    }

}
