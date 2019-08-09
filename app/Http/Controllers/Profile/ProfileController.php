<?php

namespace App\Http\Controllers\Profile;

use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public $profile_repositroy;

    public function __construct(ProfileRepository $profileRepositroy)
    {
        $this->profile_repositroy = $profileRepositroy;
        $this->middleware('profile')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $profiles = $this->profile_repositroy->findAndPaginate(10);
        return response()->json([
            'data' => $profiles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $profile = $this->profile_repositroy->findOne('user_uuid', request()->uuid);
        return response()->json([
            'data' => $profile
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
        
        $data = request()->only('first_name', 'last_name', 'image', 'city', 'country', 'location');
        if(count($data) === 0) {
            return response()->json([
                'success' => 'false',
                'message' => 'Please pass one value to update'
            ], Response::HTTP_BAD_REQUEST);
        }
        $data['user_uuid'] = auth()->user()->uuid;
        $profile = Profile::updateProfile($data);

        if ($profile) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        }
        return response()->json([
            'success' => 'false',
            'message' => 'Profile was not updated successfully'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
