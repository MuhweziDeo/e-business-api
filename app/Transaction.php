<?php

namespace App;

use App\User;
use App\Product;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function validateCreate($data)
    {
        $rules = [
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer'
        ];
        return Helpers::validate($data, $rules);
    }

    public static function canTransact(User $buyer, Product $product)
    {
        return $buyer->uuid === $product->seller_uuid;
    }
}
