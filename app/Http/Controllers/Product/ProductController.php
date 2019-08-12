<?php

namespace App\Http\Controllers\Product;

use App\Factories\ProductFactory;
use App\Helpers\Helpers;
use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public $product_repository;
    public $product_factory;

    public function __construct(ProductFactory $productFactory,
                                ProductRepository $productRepository)
    {
        $this->product_repository = $productRepository;
        $this->product_factory = $productFactory;
        $this->middleware('authorization')->except('index', 'show');
        $this->middleware(['product', 'authorization'])->only('destroy', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = $this->product_repository->findAndPaginate(10);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Product::validateCreate($request->all());

        if($validate['errors']) {
            return response()->json([
                'errors' => Helpers::formatErrors($validate)
            ],Response::HTTP_BAD_REQUEST);
        }
        $data = $request->only('name', 'description', 'category_id', 'quantity', 'image');
        $data['seller_uuid'] = $request->user->uuid;
        $product = $this->product_factory->create($data);
        return response()->json([
            'data' => $product,
            'success' => true,
            'message' => 'Product created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = $this->product_repository->findOneById($id);
        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validate = Product::validateUpdate($request->all());

        if($validate['errors']) {
            return response()->json([
                'errors' => Helpers::formatErrors($validate)
            ],Response::HTTP_BAD_REQUEST);
        }
        $data = $request->only('name', 'description', 'category_id', 'quantity', 'image', 'status');

        Product::updateProduct($request->product, $data );

        return response()->json([
            'message' => 'Product successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::deleteProduct($request->product);
        return response()->json([
        'message' => 'Product successfully deleted'
        ]);
    }
}
