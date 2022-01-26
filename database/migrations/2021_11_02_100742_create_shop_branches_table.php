<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address');
            $table->json('phone_numbers')->nullable();
            $table->json('working_days')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('shop_branches');
    }
}
