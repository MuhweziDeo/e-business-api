<?php

namespace App;

use App\Helpers\Helpers;
use App\Mail\EmailConfirmationMail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Mail\PasswordResetEmail;

class User extends Authenticatable implements JWTSubject
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

    /**
     * @param $value
     */
    protected function setPasswordAttribute($value)
    {

        $this->attributes['password'] = bcrypt($value);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_uuid', 'uuid');
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {

        return [];
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin === User::ADMIN_USER;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified === User::VERIFIED_USER;
    }


    /**
     * @param array $data
     * @return array
     */
    public static function validate(Array $data) {
        $rules = [
            'name' => 'required|min:5|unique:users',
            'password' => 'required|confirmed',
            'email' => 'required|min:5|email|unique:users'
        ];
        return Helpers::validate($data, $rules);

    }

    public static function validate_password_change($data) {
        $rules = [
            'password' => 'required|confirmed',
        ];
        return Helpers::validate($data, $rules);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public static function createUser(Array $data)
    {
        $data['uuid'] = Str::random(20);
        return User::create($data);
    }

    public static function update_user(Array $data)
    {
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        }
        return User::where('uuid', $data['uuid'])
                ->update($data);
    }

    /**
     * @return mixed
     */
    public static function getUsers()
    {
        return User::orderBy('created_at', 'DESC')->paginate(10);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public static function SendEmailVerification(User $user)
    {
        $token = auth()->login($user);
        $email_verification_link  = env('ACTIVATION_DOMAIN'). "confirmation" . "?token=$token";
        dd($email_verification_link);
        return Mail::to($user)->send(new EmailConfirmationMail($user->email, $user->name,
            $email_verification_link));

    }

    public static function sendResetPasswordEmail(User $user)
    {
        $token = auth()->login($user);
        $password_reset_link  = env('ACTIVATION_DOMAIN'). "password-reset/confirm" . "?token=$token";
        dd($password_reset_link);
        return Mail::to($user)->send(new PasswordResetEmail($user,
            $password_reset_link));

    }




}
