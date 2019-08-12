<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\PermissionHelper;
use App\Transaction;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Response;
use App\Product;

class TransactionController extends Controller
{
    public $transaction_repository;
    public $product_repository;

    public function __construct(TransactionRepository $transactionRepository,
                                    ProductRepository $productRepository)
    {
        $this->middleware('authorization');
        $this->transaction_repository = $transactionRepository;
        $this->product_repository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $transactions = auth()->user()->admin !== "false" ? $this->transaction_repository->findAll() :
            $this->transaction_repository->findAndFilter(auth()->user()->id);

        return response()->json([
            'data' => $transactions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        $validate = Transaction::validateCreate(request()->all());
        if($validate['errors']) {
            return response()->json([
                'errors' => Helpers::formatErrors($validate)
            ]);
        }
        $id = request()->only('product_id');
        $product = $this->product_repository->findOneById($id);
        if(!$product) {
            return response()->json([
                'message' => 'Product not found',
                'success' => false
            ], Response::HTTP_NOT_FOUND);
        }
        $canNotTransact = Transaction::canTransact(auth()->user(), $product);
        if($canNotTransact) {
            return response()->json([
                'message' => 'You can not buy your own product',
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        if($product->status === Product::UNAVAILABLE_PRODUCT ||
            request()->only('quantity')['quantity'] > $product->quantity) {

            $message = $product->status === Product::UNAVAILABLE_PRODUCT ?
            'Sorry this Product is not unavailable' :
                "The quantity order for is greater than what is available";

            return response()->json([
                'message' => $message,
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }
        $remaining_product_quantity = $product->quantity - request()->only('quantity')['quantity'];
        $product->quantity = $remaining_product_quantity;
        $product->status = $remaining_product_quantity === 0 ? Product::UNAVAILABLE_PRODUCT :
                            Product::AVAILABLE_PRODUCT;
        $product->save();
        $data = request()->only('quantity', 'product_id');
        $data['buyer_id'] = auth()->user()->id;
        $transaction = Transaction::create($data);
        return response()->json([
            'data' => $transaction,
            'message' => 'Transaction was successful',
            'success' => true
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
        $transaction = $this->transaction_repository->findOneById($id);
        if(!$transaction) {
            return response()->json([
                'message' => 'Transaction not found',
                'success' => false
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'data' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = $this->transaction_repository->findOneById($id);

        if(!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $isOwner = auth()->user()->id === $transaction->buyer_id;
        if(!$isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
        $data = $request->only('product_id', 'status', 'quantity');
        $d = Transaction::updateTransaction($transaction, $data);
        return response()->json([
           'message' => $d ? "Transaction updated successfully" : "Transaction not updated",
           'success' => $d
        ],$d ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = $this->transaction_repository->findOneById($id);

        if(!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $isOwner = auth()->user()->id === $transaction->buyer_id;
        if(!$isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied'
            ]);
        }
        $d = Transaction::deleteTransaction($transaction);
        return response()->json([
            'message' => $d ? "Transaction deleted successfully" : "Transaction not deleted",
            'success' => $d
        ],$d ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
