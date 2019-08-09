<?php
/**
 * Created by PhpStorm.
 * User: dee
 * Date: 2019-08-08
 * Time: 20:32
 */

namespace App\Factories;


use App\Category;

class CategoryFactory implements IFactoryInterface
{

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function findOrCreate($data)
    {
        return Category::firstOrCreate([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }
}
