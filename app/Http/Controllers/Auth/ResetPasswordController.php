<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Helpers\Helpers;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Auth\Passwords\CanResetPassword;

class ResetPasswordController extends Controller
{
    use CanResetPassword;

    public $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function reset_password_request()
    {

        $rules = [
            'email' => 'required|email'
        ];

        $validate = Helpers::validate(request()->all(), $rules);

        if($validate['errors']) {
            return response()->json([
                'errors' => Helpers::formatErrors($validate)
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->user_repository->findOne('email', request()->only('email'));

        if(!$user) {

            return response()->json([
                'success' => false,
                'message' => 'User with email not found'
            ]);
        }
        User::sendResetPasswordEmail($user);
        return response()->json([
            'success' => false,
            'message' => 'Password reset link has been sent'
        ]);


    }

    public function reset_password_confirm()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'There is a problem with the link',
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }
        $validate = User::validate_password_change(request()->all());

        if($validate['errors']) {
            return response()->json([
                'errors' => Helpers::formatErrors($validate)
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = request()->only('password');

        $data['uuid'] = $user->uuid;

        User::update_user($data);

        return response()->json([
            'message' => 'Password Reset successfully',
            'success' => true
        ]);
    }
}
