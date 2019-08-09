<?php

namespace App\Http\Middleware;

use App\Helpers\PermissionHelper;
use App\Repositories\ProductRepository;
use Closure;
use Illuminate\Http\Response;

class ProductMiddleware
{
    public $product_repository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->product_repository = $productRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $id = $request->route()->parameters()['product'];
        $product = $this->product_repository->findOneById($id);
        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found'
            ]);
        }

        if($request->method() === 'PUT' || $request->method() === 'DELETE') {
            $isOwner = PermissionHelper::IsOwner(auth()->user(), $product->seller_uuid);
            if(!$isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Permission Denied'
            ], Response::HTTP_FORBIDDEN);
            }
        }

        $request->product = $product;
        return $next($request);
    }
}
