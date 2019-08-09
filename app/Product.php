<?php

namespace App;

use App\Helpers\Helpers;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_uuid',
        'category_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_uuid', 'uuid');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function isAvailable()
    {
        return $this->status === Product::AVAILABLE_PRODUCT;
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function validateCreate($data)
    {
        $rules = [
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'integer',
            'image' => 'required|string|min:3',
            'status' => Product::AVAILABLE_PRODUCT
        ];
        return Helpers::validate($data, $rules);
    }

    public static function validateUpdate($data) {
        $rules = [
            'name' => 'string|min:3',
            'description' => 'string|min:3',
            'quantity' => 'integer|min:0',
            'category_id' => 'integer',
            'image' => 'string|min:3'
        ];
        return Helpers::validate($data, $rules);
    }

    public static function updateProduct(Product $product, Array $data)
    {
        return $product->update($data);
    }

    public static function deleteProduct(Product $product)
    {
        return $product->delete();
    }
}
