<?php


namespace App\Repositories;


use App\Category;

class CategoryRepository implements IBaseRepository
{

    public function findAll()
    {

        return Category::all();
    }

    public function findOneById($id)
    {

        return Category::find($id);
    }

    public function findAndPaginate($paginateSize)
    {

        return Category::orderBy('name', 'DESC')->paginate($paginateSize);
    }

    public function findOne($key, $value)
    {

    }

    public function findAndFilter($filter)
    {
        // TODO: Implement findAndFilter() method.
    }

    
}
