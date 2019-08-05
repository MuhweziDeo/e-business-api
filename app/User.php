<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use Notifiable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
        'uuid'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isAdmin()
    {
        return $this->admin === User::ADMIN_USER;
    }

    public function isVerified()
    {
        return $this->verified === User::VERIFIED_USER;
    }

    public static function generateVerificationToken()
    {
        return Str::random(40);
    }

    public static function validate(Array $data) {
        $rules = [
            'name' => 'required|min:5|unique:users',
            'password' => 'required|confirmed',
            'email' => 'required|min:5|email|unique:users'
        ];

        return \App\Helpers\Helpers::validate($data, $rules);

    }

    public static function createUser(Array $data)
    {
        $data['uuid'] = Str::random(20);
        return User::create($data);
    }

    public static function getUsers()
    {
        return User::orderBy('created_at', 'DESC')->paginate(10);
    }


}
