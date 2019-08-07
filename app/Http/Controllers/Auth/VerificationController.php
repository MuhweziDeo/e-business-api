<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class VerificationController extends Controller
{
   public function confirmEmail(Request $request)
   {

       $user = auth()->user();
       if (!$user || $user->verified === User::VERIFIED_USER) {

            $message = $user->verified ? 'Account already verified' :
                'There is a problem with the link';
           return response()->json([
               'message' => $message,
               'success' => false
           ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
       }
       $user->verified = User::VERIFIED_USER;
       $user->email_verified_at = Carbon::now();
       $user->save();
       $validate = Profile::validate(request()->all());
       if($validate['errors']) {
           return response()->json($validate['errors']);
       }
       $data = request()->only('first_name', 'last_name', 'image', 'city', 'country', 'location');
       $profile = [];
       if(count($data) > 0) {
            $data['user_uuid'] = $user->uuid;
            $profile = Profile::updateProfile($data);
       }
       $message = $profile ? 'Account activated and Profile updated succesfully' :
                             'Account activated succesfully';
       return response()->json([
           'message' => $message,
           'success' => true
       ]);
   }
}
