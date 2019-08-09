<?php


namespace App\Factories;


use App\Product;

class ProductFactory implements IFactoryInterface
{

    /**
     * @param array $data
     * @return mixed
     */
    public function create(Array $data)
    {

        return Product::create($data);
    }

    /**
     * @param $data
     */
    public function findOrCreate($data)
    {
        // TODO: Implement findOrCreate() method.
    }
}
