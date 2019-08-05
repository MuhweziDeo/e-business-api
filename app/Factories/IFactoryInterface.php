<?php
/**
 * Created by PhpStorm.
 * User: dee
 * Date: 2019-08-04
 * Time: 19:52
 */

namespace App\Factories;


interface IFactoryInterface
{

    public function create(Array $data);

    public function findOrCreate($data);

}
