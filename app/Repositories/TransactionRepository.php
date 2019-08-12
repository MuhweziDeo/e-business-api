<?php

namespace App\Repositories;

use App\Repositories\IBaseRepository;
use App\Transaction;

class TransactionRepository implements IBaseRepository
{
    public function findAndPaginate($paginateSize)
    {
        return Transaction::orderBy('created_at')->paginate($paginateSize);
    }

    public function findAll()
    {
        return Transaction::all();
    }

    public function findOneById($id)
    {
        return Transaction::find($id);
    }

    public function findOne($key, $value)
    {

    }
    public function findAndFilter($filter)
    {
        return Transaction::where('buyer_id', $filter)->get();
    }
}
