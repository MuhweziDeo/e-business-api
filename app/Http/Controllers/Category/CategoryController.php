<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Factories\CategoryFactory;
use App\Helpers\Helpers;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public $category_repository;
    public $category_factory;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(CategoryRepository $categoryRepository,
                                CategoryFactory $categoryFactory)
    {
       $this->category_repository = $categoryRepository;
       $this->category_factory = $categoryFactory;
       $this->middleware('authorization')->except('on');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = $this->category_repository->findAndPaginate(10);

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validate = Category::validate($request->all());
        if($validate['errors']) {
            return response()->json([
                'errors' => Helpers::formatErrors($validate)
            ]);
        }
        $data = $request->only('name', 'description');
        $category = $this->category_factory->create($data);
        return response()->json([
            'data' => $category
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
