<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\JWTHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProfileRepository;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public $profile_repository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profile_repository = $profileRepository;

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = JWTHelper::generateToken($credentials);

        if (!$token) {
           return response()->json([
               'message' => 'Invalid Login credentials',
               'success' => false
           ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'access_token' => $token,
            'message' => 'Login Successful',
            'success' => false
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth()->logout();
        return response()->json([
            'message' => 'LogOut Successful',
            'success' => false
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        $user = auth()->user();
        if(!$user) {
            return response()->json([
                'message' => 'Invalid Token',
                'success' => false
            ], Response::HTTP_UNAUTHORIZED);
        }

        $profile = $this->profile_repository->findOne('user_uuid', $user->uuid);

        return response()->json([
            'data' => $profile,
            'success' => true
        ]);
    }
}
