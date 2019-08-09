<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Helpers\PermissionHelper;
use App\Repositories\ProfileRepository;

class ProfileMiddleware
{

    public $profile_repository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profile_repository = $profileRepository;

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $profile = $this->profile_repository->findOne('user_uuid', $request->uuid);
        if (!$profile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matching profile not found'
                ], Response::HTTP_NOT_FOUND);
        }

        if($request->method() === 'PUT') {
            $current_user = auth()->user();

            if(!$current_user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'UnAuthorised'
                    ], Response::HTTP_UNAUTHORIZED);
            }
            $isOwner = PermissionHelper::IsOwner($current_user, $request->uuid);

            if(!$isOwner) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Permission Denied'
                    ], Response::HTTP_FORBIDDEN);
                }
            }

        return $next($request);

    }
}
