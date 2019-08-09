<?php


namespace App\Repositories;


use App\Product;

class ProductRepository implements IBaseRepository
{


    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        return Product::all();
    }

    /**
     * @param $id
     * @return Product|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findOneById($id)
    {
        return Product::with('seller.profile', 'category')
                        ->where('id', $id)
                        ->first();
    }

    /**
     * @param $paginateSize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAndPaginate($paginateSize)
    {
        return Product::with('seller.profile', 'category')
                        ->paginate($paginateSize);
    }

    public function findOne($key, $value) { }
}
