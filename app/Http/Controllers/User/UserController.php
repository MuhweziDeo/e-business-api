<?php

namespace App\Http\Controllers\User;

use App\Events\Registration;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $user_repository;

    public function __construct(UserRepository $repository)
    {
        $this->user_repository = $repository;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = $this->user_repository->findAndPaginate(10);
        return response()->json([
            'data' => $users
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
        $validate = User::validate($request->all());
        if ($validate['errors']) {
            $errors = \App\Helpers\Helpers::formatErrors($validate);
            return response()->json([ 'errors' =>  $errors], Response::HTTP_BAD_REQUEST);
        }
        $data = $request->only('name', 'email', 'password');
        $user = User::createUser($data);
        event(new Registration($user->email, $user->name));
        return response()->json([
            'data' => $user,
            'success' => true,
            'message' => 'Registration complete please check email to continue registration'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
