<?php

namespace App\Repositories;

use App\Repositories\IBaseRepository;
use App\Profile;

class ProfileRepository implements IBaseRepository
{
    public function findOne($key, $value)
    {
        return Profile::with('user')->where($key, $value)->first();
    }

    public function findAll()
    {
        return Profile::all();
    }

    public function findAndPaginate($paginateSize)
    {
        return Profile::with('user')->paginate(10);
    }

    public function findOneById($id)
    {
        return Profile::findById($id);
    }
}
