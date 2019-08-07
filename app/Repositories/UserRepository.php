<?php

namespace App\Repositories;

use App\User;

class UserRepository implements IBaseRepository
{


    /**
     * Display a listing of the users.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection of User
     */
    public function findAll()
    {
        return User::all();
    }


    /**
     * Display a user.
     *
     * @param $id
     * @return User
     */

    public function findOneById($id)
    {
        return User::find($id);
    }


    /**
     * Display a listing Users
     *
     * @param $paginateSize
     * @return User[]|\Illuminate\Database\Eloquent\Collection of User
     */

    public function findAndPaginate($paginateSize)
    {

        return User::orderBy('created_at', 'DESC')->paginate($paginateSize);
    }

    public function findOne($key, $value)
    {
        return User::where($key, $value)->first();
    }


}



