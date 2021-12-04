<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopBranchImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_branch_images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('extensions');
            $table->unsignedBigInteger('shop_branch_id')->nullable();

            $table->foreign('shop_branch_id')->references('id')->on('shop_branches')->onDelete('cascade');
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
        Schema::dropIfExists('shop_branch_images');
    }
}
