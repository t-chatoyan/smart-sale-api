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
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('1c_id')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->double('price');
            $table->double('old_price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('in_stock')->nullable();
            $table->boolean('is_available')->default(true);
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
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
