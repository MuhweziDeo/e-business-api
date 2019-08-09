<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->integer('quantity')->unsigned();
            $table->string('status')->default(\App\Product::UNAVAILABLE_PRODUCT);
            $table->string('image');
            $table->string('seller_uuid');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();


            $table->foreign('seller_uuid')->references('uuid')->on('users')
                    ->onDelete('cascade');

            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade');


        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
