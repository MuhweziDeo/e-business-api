<?php


namespace App\Factories;


interface IFactoryInterface
{

    public function create(Array $data);

    public function findOrCreate($data);

}
