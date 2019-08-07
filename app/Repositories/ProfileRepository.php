<?php

namespace App\Repositories;

use App\Repositories\IBaseRepository;
use App\Profile;

class ProfileRepository implements IBaseRepository
{
    public function findOne($key, $value)
    {
        return Profile::where($key, $value)->first();
    }

    public function findAll()
    {
        return Profile::all();
    }

    public function findAndPaginate($paginateSize)
    {
        return Profile::orderBy('created_at', 'DESC')->paginate($paginateSize);
    }

    public function findOneById($id)
    {
        return Profile::findById($id);
    }
}
