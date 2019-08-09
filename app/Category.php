<?php

namespace App;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @param $data
     * @return array
     */
    public static function validate(Array $data)
    {
        $rules = [
            'name' => 'required|unique:categories|min:3',
            'description' => 'required|string|min:3'
        ];

        return Helpers::validate($data, $rules);
    }
}
