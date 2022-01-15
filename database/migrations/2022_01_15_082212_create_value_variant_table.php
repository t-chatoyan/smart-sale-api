<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValueVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_variant', function (Blueprint $table) {
            $table->unsignedBigInteger('value_id');
            $table->foreign('value_id')
                ->references('id')
                ->on('values')
                ->onDelete('cascade');

            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onDelete('cascade');

            $table->primary(['value_id', 'variant_id']);

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
        Schema::dropIfExists('value_variant');
    }
}
