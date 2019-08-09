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

    }

    public function findOneById($id)
    {

    }

    public function findOne($key, $value)
    {

    }
}
