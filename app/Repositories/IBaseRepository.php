<?php
/**
 * Created by PhpStorm.
 * User: dee
 * Date: 2019-08-04
 * Time: 16:03
 */

namespace App\Repositories;


interface IBaseRepository
{

    public function findAll();

    public function findOneById($id);

    public function findAndPaginate($paginateSize);

    public function findOne($key, $value);

    public function findAndFilter($filter);


}
