<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id()->startingValue(10000);
            $table->string('product_code')->unique();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('slug')->unique();
            $table->string('image');
            $table->float('price');
            $table->integer('total_sold')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('stock')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
